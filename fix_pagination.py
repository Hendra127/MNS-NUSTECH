import os
import re

files_info = {
    r'd:\NEWNUSTECH\resources\views\datapas.blade.php': '$datapass',
    r'd:\NEWNUSTECH\resources\views\pergantianperangkat.blade.php': '$data',
    r'd:\NEWNUSTECH\resources\views\sparetracker.blade.php': '$data',
}

for filepath, var_name in files_info.items():
    if not os.path.exists(filepath): continue
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    if "links(" not in content:
        pattern = re.compile(r'(</table>\s*</div>)', re.IGNORECASE)
        replace_with = r'\1\n        <div class="mt-3 pagination-wrapper">\n            {{ ' + var_name + r'->appends(request()->query())->links("pagination::bootstrap-5") }}\n        </div>'
        
        new_content = pattern.sub(replace_with, content, count=1)
        
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f'Added pagination to {os.path.basename(filepath)}')
