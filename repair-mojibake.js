const fs = require('fs');
const path = require('path');

const replacements = {
    'ðŸ”': '🔍',
    'â†’': '→',
    'â€¢': '•',
    'â€”': '—',
    'Â·': '·',
    'â€˜': '‘',
    'â€™': '’',
    'â€œ': '“',
    'â€': '”'
};

function walkDir(dir) {
    const files = fs.readdirSync(dir);
    for (const file of files) {
        const fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            walkDir(fullPath);
        } else if (fullPath.endsWith('.blade.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            let modified = false;
            
            for (const [bad, good] of Object.entries(replacements)) {
                if (content.includes(bad)) {
                    content = content.split(bad).join(good);
                    modified = true;
                }
            }
            
            if (modified) {
                fs.writeFileSync(fullPath, content, 'utf8');
                console.log('Fixed encoding in:', file);
            }
        }
    }
}

walkDir('d:/NEWNUSTECH/resources/views');
