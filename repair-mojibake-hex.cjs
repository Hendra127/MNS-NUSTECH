const fs = require('fs');
const path = require('path');

const hexReplacements = {
    'c3b0c5b8e2809dc28d': 'f09f948d', // 🔍
    'c3a2e280a0e28099': 'e28692', // →
    'c3a2e282acc2a2': 'e280a2', // •
    'c3a2e282ace2809d': 'e28094', // —
    'c382c2b7': 'c2b7' // ·
};

function walkDir(dir) {
    const files = fs.readdirSync(dir);
    let totalFixed = 0;
    for (const file of files) {
        const fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            totalFixed += walkDir(fullPath);
        } else if (fullPath.endsWith('.blade.php')) {
            const contentBuffer = fs.readFileSync(fullPath);
            let hexContent = contentBuffer.toString('hex');
            let modified = false;
            
            for (const [badHex, goodHex] of Object.entries(hexReplacements)) {
                if (hexContent.includes(badHex)) {
                    hexContent = hexContent.split(badHex).join(goodHex);
                    modified = true;
                }
            }
            
            if (modified) {
                fs.writeFileSync(fullPath, Buffer.from(hexContent, 'hex'));
                console.log('Fixed binary encoding in:', file);
                totalFixed++;
            }
        }
    }
    return totalFixed;
}

const fixedCount = walkDir('d:/NEWNUSTECH/resources/views');
console.log('Total files repaired:', fixedCount);
