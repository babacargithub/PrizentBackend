import tkinter as tk
from tkinter import filedialog, messagebox
from icecream import ic
# QR code generator
import qrcode
import sys
import argparse
from PIL import Image, ImageDraw, ImageFont
import pandas as pd


def add_rounded_corners(im, rad):
    # Create a mask
    circle = Image.new('L', (rad * 2, rad * 2), 0)
    draw = ImageDraw.Draw(circle)
    draw.ellipse((0, 0, rad * 2, rad * 2), fill=255)

    alpha = Image.new('L', im.size, 255)
    w, h = im.size

    # Add four corners to the alpha mask
    alpha.paste(circle.crop((0, 0, rad, rad)), (0, 0))
    alpha.paste(circle.crop((0, rad, rad, rad * 2)), (0, h - rad))
    alpha.paste(circle.crop((rad, 0, rad * 2, rad)), (w - rad, 0))
    alpha.paste(circle.crop((rad, rad, rad * 2, rad * 2)), (w - rad, h - rad))

    # Apply the mask to the image
    im.putalpha(alpha)
    return im


# parser = argparse.ArgumentParser(description="Test script.")
# parser.add_argument('--data', type=str, help='Data of the QR code')
# parser.add_argument('--type', type=str, help='Type of the QR code. It can be either in or out.')
#
# args = parser.parse_args()
def generate_badge_image(data):
    # # Define PVC size at 300 DPI
    A5_PIXELS_X = 1004
    A5_PIXELS_Y = 638

    # Create an A5 canvas
    a5_img = Image.open('green-zebra-bg.jpeg').convert('RGBA')
    a5_img = a5_img.resize((1004, 638))

    # Create the QR code
    qr_data = data
    qr_code = qrcode.QRCode(
        version=1,
        error_correction=qrcode.constants.ERROR_CORRECT_H,
        box_size=11,
        border=6,
    )
    qr_code.add_data(qr_data)
    qr_code.make(fit=True)
    qr_code_image = qr_code.make_image(fill='black', back_color='white').convert('RGB')

    prizent_logo = Image.open('prizent_logo.png')
    prizent_logo_rounded = Image.open('prizent_logo_rounded.png').convert('RGBA')
    prizent_logo_rounded.thumbnail((100, 100))

    # Calculate position for QR code (centered)
    qr_size = qr_code_image.size
    qr_x = (A5_PIXELS_X - qr_size[0]) // 2
    qr_y = (A5_PIXELS_Y - qr_size[1]) // 2

    # Paste the QR code onto the A5 canvas
    # a5_img.paste(prizent_logo_rounded, ((A5_PIXELS_X - prizent_logo_rounded.size[0]) // 2, 40))
    a5_img.paste(qr_code_image, (qr_x, qr_y))
    a5_img.paste(prizent_logo_rounded, ((A5_PIXELS_X - prizent_logo_rounded.size[0]) // 2, 40),
                 mask=prizent_logo_rounded.split()[3])

    # Add SORTIE text under the QR code
    draw = ImageDraw.Draw(a5_img)
    font_size_big = 200  # size of the font
    font_size_medium = 60
    font_size_small = 30
    # size of the font
    font_normal = ImageFont.truetype('arial.ttf', font_size_medium)
    font_bold = ImageFont.truetype('arial_bold.ttf', font_size_big)
    font_small = ImageFont.truetype('arial.ttf', font_size_small)

    # Position the SORTIE text to be centered under the QR code
    text = "SORTIE"
    # text_w, text_h = draw.textlength(text, font=font)
    # text_x = (A5_PIXELS_X - text_w) // 2
    # text_y = qr_y + qr_size[1] + 50
    # 50 pixels below the QR code

    # Draw the text onto the image
    # draw.text((500, prizent_logo.size[1] + 43), text, fill="white", font=font_bold)

    # Draw the code below the qr code
    draw.text((430, 470), qr_data, fill="black", font=font_small)
    # Tagline
    tagline = "Badge de pointage Prizent"
    # Draw the code below the qr code
    # draw.text((430, 550), tagline, fill="black", font=font_small)

    taglineRectangle = Image.new('RGBA', (400, 50), 'green')
    taglineDraw = ImageDraw.Draw(taglineRectangle)
    taglineDraw.text((20, 4), tagline, fill="white", font=font_small)
    # Paste the tagline onto the A5 canvas
    a5_img.paste(taglineRectangle, ((A5_PIXELS_X - taglineRectangle.size[0]) // 2, 550))
    # Save the image
    a5_img = a5_img.convert('RGBA')
    a5_img.save(f'output/badge_{qr_data}.png')


def generate_qr_code_image(data, qr_code_type):
    # Define A5 size at 300 DPI
    a5_pixels_x = 1748
    a5_pixels_y = 2480

    # Create an A5 canvas
    a5_img = Image.new('RGBA', (a5_pixels_x, a5_pixels_y), color='green')

    # Create the QR code

    qr_code_data = data
    qr_code_type_label = "ENTRÉE" if qr_code_type == 'in' else "SORTIE"
    qr = qrcode.QRCode(
        version=1,
        error_correction=qrcode.constants.ERROR_CORRECT_H,
        box_size=35,
        border=6,
    )
    qr.add_data(qr_code_data)
    qr.make(fit=True)
    qr_img = qr.make_image(fill='black', back_color='white').convert('RGB')
    prizent_logo = Image.open('prizent_logo.png')
    # prizent_logo_rounded = Image.open('prizent_logo_rounded.png').convert('RGBA').resize((512, 512))
    prizent_logo_rounded = add_rounded_corners(prizent_logo, 100).convert('RGBA').resize((512, 512))

    # Calculate position for QR code (centered)
    qr_size = qr_img.size
    qr_x = (a5_pixels_x - qr_size[0]) // 2
    qr_y = (a5_pixels_y - 800) // 2

    # Paste the QR code onto the A5 canvas
    a5_img.paste(prizent_logo_rounded, ((a5_pixels_x - prizent_logo_rounded.size[0]) // 2, 40),
                 mask=prizent_logo_rounded.split()[3])
    a5_img.paste(qr_img, (qr_x, qr_y))

    # Add SORTIE text under the QR code
    draw = ImageDraw.Draw(a5_img)
    font_size_big = 200  # size of the font
    font_size_medium = 100
    font_size_small = 50
    # size of the font
    font_normal = ImageFont.truetype('arial.ttf', font_size_medium)
    font_bold = ImageFont.truetype('arial_bold.ttf', font_size_big)
    font_small = ImageFont.truetype('arial.ttf', font_size_small)

    # Position the label text to be centered under the QR code
    text = qr_code_type_label
    # text_w, text_h = draw.textlength(text, font=font)
    # text_x = (A5_PIXELS_X - text_w) // 2
    # text_y = qr_y + qr_size[1] + 50
    # 50 pixels below the QR code

    # Draw the text onto the image
    draw.text((500, prizent_logo.size[1] + 43), text, fill="white", font=font_bold)

    # Draw the code below the qr code
    draw.text((700, 2180), qr_code_data, fill="white", font=font_small)

    # Save the image
    a5_img.save(f'/Users/macm22023/Documents/QR_CODES/qr_code_image_{qr_code_data}.png')


def load_excel(file_type):
    # Open a file dialog to select an Excel file
    file_path = filedialog.askopenfilename(filetypes=[("Excel files", "*.xlsx *.xls")])
    # file_path = '/Users/macm22023/Documents/test_qr_code.xlsx'
    if file_path:
        try:
            # Load the Excel file
            df = pd.read_excel(file_path)
            # Extract the first column, assuming it doesn't have a header you can reference by name
            for index, row in df.iterrows():
                entry = row.tolist()
                if file_type == 'qr_code':
                    generate_qr_code_image(str(entry[0]), entry[1])
                else:
                    generate_badge_image(str(entry[0]))

            if file_type == 'qr_code':
                messagebox.showinfo("Success", "QR codes générés avec succès !")
            elif file_type == 'badge':
                messagebox.showinfo("Success", "Badges générés avec succès !")
            else:
                raise Exception("Invalid file type")
            # Display in the listbox
            # listbox.delete(0, tk.END)  # Clear existing items
            # for value in first_column_values:
            #     listbox.insert(tk.END, value)  # Insert each new item

        except Exception as e:
            # print(f"Failed to read the Excel file: {e}")
            messagebox.showerror("Error", f"Failed to read the Excel file: {e}")


# Create the main window
root = tk.Tk()
root.title("Excel File Processor")

# Set a minimum window size
root.minsize(900, 900)  # Increased height to accommodate listbox

# Create a button to open the file dialog
load_button = tk.Button(root, text="Charger fichier de QR Codes", command=lambda: load_excel('qr_code'))
load_button.pack(pady=10)
load_badge_button = tk.Button(root, text="Charger fichier de badges", command=lambda: load_excel('badge'))
load_badge_button.pack(pady=10)

# Start the GUI event loop
root.mainloop()
