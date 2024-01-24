#!/bin/sh

# Check if the image directory argument is provided
if [ $# -eq 0 ]; then
  echo "Usage: $0 <image_directory>"
  exit 1
fi

# Directory containing the script
script_dir="$(cd "$(dirname "$0")" && pwd)"

# Directory containing the image files
image_dir="$1"

# Full path to the image directory
full_image_dir="$script_dir/$image_dir"

# Counter for the image number
image_number=1

# Check if the specified directory exists
if [ ! -d "$full_image_dir" ]; then
  echo "Directory '$full_image_dir' not found."
  exit 1
fi

# Loop through image files in the directory
for image_file in "$full_image_dir"/*; do
  # Check if the file is an image (you can modify the extensions as needed)
  if [ -f "$image_file" ] && echo "$image_file" | grep -E -q '\.(jpg|jpeg|png|gif|bmp)$'; then
    # Generate the new name using the format "image-number"
    new_name="image-$image_number"

    # Rename the image file
    mv "$image_file" "$full_image_dir/$new_name.${image_file##*.}"

    # Increment the image number
	image_number=$(($image_number + 1))
  fi
done

echo "Renamed $((image_number-1)) image files in $full_image_dir."
