import os
import glob

files = glob.glob('resources/views/**/*.blade.php', recursive=True)
for f in files:
    with open(f, 'r', encoding='utf-8') as file:
        content = file.read()
    if 'css/password.css' in content:
        new_content = content.replace("css/password.css') }}?v=2.0", "css/password.css') }}?v=3.0")
        if new_content != content:
            with open(f, 'w', encoding='utf-8') as file:
                file.write(new_content)
                print(f"Updated {f}")
