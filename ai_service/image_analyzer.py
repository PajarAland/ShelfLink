import cv2
import numpy as np

def analyze_image(image_bytes):
    """
    Analyzes raw image bytes using OpenCV for physical damage signs like rips, creases, 
    stains, or scribbles. Uses edge density and contour complexity calculations.
    """
    # Convert raw bytes to numpy array
    nparr = np.frombuffer(image_bytes, np.uint8)
    img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)
    if img is None:
        raise ValueError("Invalid image file or format")

    # Resize image to normalize pixel density calculations and improve execution speed
    max_dimension = 800
    h, w = img.shape[:2]
    if max(h, w) > max_dimension:
        scale = max_dimension / max(h, w)
        img = cv2.resize(img, (int(w * scale), int(h * scale)))
        h, w = img.shape[:2]

    # Convert to grayscale
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

    # Apply strong Gaussian Blur to smooth out printed text, titles, and graphic details
    blurred = cv2.GaussianBlur(gray, (15, 15), 0)

    # Run Canny Edge Detection with higher thresholds to capture only major physical disruptions
    edges = cv2.Canny(blurred, 80, 200)

    # Calculate Edge Density (ratio of white edge pixels to total pixels)
    total_pixels = h * w
    edge_pixels = np.sum(edges == 255)
    edge_density = float(edge_pixels / total_pixels)

    # Detect Contours (shapes and irregular shapes on the cover)
    contours, _ = cv2.findContours(edges, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    
    # Filter out small noise contours below 15 pixels area
    large_contours = [c for c in contours if cv2.contourArea(c) > 15]
    contour_count = len(large_contours)

    # Calibrated Threshold settings:
    # A strong Gaussian blur (15, 15) suppresses printed book graphics, reducing their density to <0.6%.
    # Rips, heavy stains, writing, and deep creases still stand out above these values.
    edge_density_threshold = 0.007
    contour_threshold = 5

    is_damaged = False
    details = []
    confidence = 0.0
    suggested_fine = 0

    if edge_density > edge_density_threshold:
        is_damaged = True
        details.append(f"High surface texture/edge density detected ({edge_density * 100:.2f}%). Possible creases, rips, or writing.")
    
    if contour_count > contour_threshold:
        is_damaged = True
        details.append(f"Abnormal count of irregular surface contours detected ({contour_count} segments).")

    if is_damaged:
        # Calculate confidence based on how much metrics exceed baseline thresholds
        density_exceed = min((edge_density - edge_density_threshold) / 0.01, 1.0) if edge_density > edge_density_threshold else 0
        contour_exceed = min((contour_count - contour_threshold) / 20, 1.0) if contour_count > contour_threshold else 0
        
        confidence = float(0.5 + 0.5 * max(density_exceed, contour_exceed))
        confidence = min(max(confidence, 0.6), 0.99)
        
        # Calculate suggested fine: base fine is Rp5,000, scaling up to Rp50,000 max
        severity = max(density_exceed, contour_exceed)
        suggested_fine = int(5000 + 45000 * severity)
        suggested_fine = int(round(suggested_fine / 500) * 500) # Round to nearest Rp500
    else:
        is_damaged = False
        confidence = float(0.85 + 0.14 * (1.0 - (edge_density / edge_density_threshold)))
        confidence = min(max(confidence, 0.8), 0.99)
        details.append("Physical structure appears intact. No major anomalies or surface disruptions detected.")
        suggested_fine = 0

    return {
        "is_damaged": is_damaged,
        "confidence": round(confidence, 2),
        "damage_details": "; ".join(details),
        "suggested_fine": suggested_fine,
        "metrics": {
            "edge_density": round(edge_density, 4),
            "contour_count": contour_count
        }
    }
