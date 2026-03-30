import os
import re

directory = r'd:\\NEWNUSTECH\\resources\\views'

with open(os.path.join(directory, 'datapas.blade.php'), 'r', encoding='utf-8') as f:
    content = f.read()
content = content.replace('<tr class="thead-dark">', '<tr>')
with open(os.path.join(directory, 'datapas.blade.php'), 'w', encoding='utf-8') as f:
    f.write(content)

with open(os.path.join(directory, r'partials\pwa-head.blade.php'), 'r', encoding='utf-8') as f:
    content = f.read()
content = content.replace('<link rel="apple-touch-icon" href="{{ asset(\'assets/img/logonustech.png\') }}">\n<script>', '<link rel="apple-touch-icon" href="{{ asset(\'assets/img/logonustech.png\') }}">\n<script src="{{ asset(\'js/ajax-search.js\') }}?v=1.0"></script>\n<script>')
with open(os.path.join(directory, r'partials\pwa-head.blade.php'), 'w', encoding='utf-8') as f:
    f.write(content)

with open(os.path.join(directory, 'datasite.blade.php'), 'r', encoding='utf-8') as f:
    content = f.read()
content = content.replace("<div class=\"mt-3\">\n        {{ $sites->links('pagination::bootstrap-5') }}\n    </div>", "<div class=\"pagination-wrapper\">\n        <span class=\"pagination-info\">\n            Showing {{ $sites->firstItem() ?? 0 }} to {{ $sites->lastItem() ?? 0 }} \n            of&nbsp;<strong>{{ $sites->total() }}</strong>&nbsp;results\n        </span>\n        <nav>\n            {{ $sites->links() }}\n        </nav>\n    </div>")
with open(os.path.join(directory, 'datasite.blade.php'), 'w', encoding='utf-8') as f:
    f.write(content)

pattern = re.compile(
    r'(?:\{\{--(?:\s*Script)[^}]*?(?:pencarian|submit|live search|delay)[^}]*?--\}\}\s*)?<script>(?:(?!</script>).)*?(?:setTimeout|timer|timeout|clearTimeout)(?:(?!</script>).)*?submit\(\)(?:(?!</script>).)*?</script>\s*',
    re.IGNORECASE | re.DOTALL
)

files_to_check = [
    'datasite.blade.php', 'datapas.blade.php', 'laporancm.blade.php',
    'open.blade.php', 'close.blade.php', 'PMLiberta.blade.php',
    'sparetracker.blade.php', 'pergantianperangkat.blade.php'
]

for filename in files_to_check:
    path = os.path.join(directory, filename)
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    new_content = pattern.sub('', content)
    
    if new_content != content:
        print(f"Cleaned {filename}")
        with open(path, 'w', encoding='utf-8') as f:
            f.write(new_content)
    else:
        print(f"Skipped {filename} (Pattern did not match)")

