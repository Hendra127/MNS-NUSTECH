import os
import re

files = [
    r"d:\NEWNUSTECH\resources\views\datasite.blade.php",
    r"d:\NEWNUSTECH\resources\views\open.blade.php",
    r"d:\NEWNUSTECH\resources\views\close.blade.php",
    r"d:\NEWNUSTECH\resources\views\laporancm.blade.php",
    r"d:\NEWNUSTECH\resources\views\PMLiberta.blade.php",
    r"d:\NEWNUSTECH\resources\views\pergantianperangkat.blade.php",
    r"d:\NEWNUSTECH\resources\views\sparetracker.blade.php",
]

for p in files:
    if os.path.exists(p):
        with open(p, 'r', encoding='utf-8') as f: 
            c = f.read()

        c = c.replace('border-radius: 20px;', '')
        c = c.replace('style=\'width: 150px; \'', 'style=\'width: 150px;\'')
        c = c.replace('style=\'width: 130px; \'', 'style=\'width: 130px;\'')
        c = c.replace('style=\'width: 140px; \'', 'style=\'width: 140px;\'')
        c = c.replace('style=\'width: 180px; \'', 'style=\'width: 180px;\'')
        c = c.replace('"width: 150px; "', '"width: 150px;"')
        c = c.replace('"width: 130px; "', '"width: 130px;"')
        c = c.replace('"width: 140px; "', '"width: 140px;"')
        c = c.replace('"width: 180px; "', '"width: 180px;"')
        c = c.replace('width: 130px;', 'width: 140px;')
        
        # Remove empty style wrappers
        c = c.replace(' style=""', '')
        
        c = c.replace('<span class=\'text-muted text-sm\'>-</span>', '')
        c = c.replace('<span class=\'text-muted text-sm\' style=\'font-size: 11px;\'>Msuk:</span>', '')
        c = c.replace('<span class=\'text-muted text-sm\' style=\'font-size: 11px;\'>Kluar:</span>', '')
        c = c.replace('<span class="text-muted text-sm">-</span>', '')
        c = c.replace('<span class="text-muted text-sm" style="font-size: 11px;">Msuk:</span>', '')
        c = c.replace('<span class="text-muted text-sm" style="font-size: 11px;">Kluar:</span>', '')

        with open(p, 'w', encoding='utf-8') as f: 
            f.write(c)

print('Done!')
