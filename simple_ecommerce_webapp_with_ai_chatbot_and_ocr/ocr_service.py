import os
import sys
import pytesseract
from PIL import Image

# Set tesseract executable and tessdata directory explicitly
pytesseract.pytesseract.tesseract_cmd = r'C:\\Program Files\\Tesseract-OCR\\tesseract.exe'
os.environ['TESSDATA_PREFIX'] = r'C:\\Program Files\\Tesseract-OCR\\tessdata'

if len(sys.argv) < 2:
    print("No image file provided")
    sys.exit(1)

image_path = sys.argv[1]
text = pytesseract.image_to_string(Image.open(image_path))
print(text)
