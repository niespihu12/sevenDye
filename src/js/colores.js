document.addEventListener('DOMContentLoaded', function() {
    const colorInput = document.getElementById('color');
    const colorPreview = document.getElementById('colorPreview');
    const colorName = document.getElementById('nombre');
    const hexValue = document.getElementById('hexValue');
    const rgbValue = document.getElementById('rgbValue');
    const hslValue = document.getElementById('hslValue');
    const similarColorsGrid = document.getElementById('similarColors');
    const colorWrapper = document.querySelector('.campo-admin__color-wrapper');
    updateColorDisplay(colorInput.value);
    colorInput.addEventListener('input', function() {
        updateColorDisplay(this.value);
    });
    function updateColorDisplay(hex) {
        colorPreview.style.backgroundColor = hex;
        hexValue.textContent = hex.toUpperCase();
        colorWrapper.setAttribute('data-value', hex.toUpperCase());
        const r = parseInt(hex.substring(1,3), 16);
        const g = parseInt(hex.substring(3,5), 16);
        const b = parseInt(hex.substring(5,7), 16);
        rgbValue.textContent = `RGB: ${r}, ${g}, ${b}`;
        const hsl = rgbToHsl(r, g, b);
        hslValue.textContent = `HSL: ${Math.round(hsl[0])}, ${Math.round(hsl[1])}%, ${Math.round(hsl[2])}%`;
        const brightness = (r * 299 + g * 587 + b * 114) / 1000;
        const textColor = brightness > 128 ? '#333333' : '#FFFFFF';
        colorPreview.querySelector('.color-preview__box-text').style.color = textColor;
        generateSimilarColors(hex);
    }
    function generateSimilarColors(hex) {
        similarColorsGrid.innerHTML = '';
        const r = parseInt(hex.substring(1,3), 16);
        const g = parseInt(hex.substring(3,5), 16);
        const b = parseInt(hex.substring(5,7), 16);
        const hsl = rgbToHsl(r, g, b);
        for (let i = 0; i < 5; i++) {
            const lighterH = hsl[0];
            const lighterS = hsl[1];
            const lighterL = Math.min(100, hsl[2] + (i+1) * 10);
            const lighterRgb = hslToRgb(lighterH, lighterS, lighterL);
            addSimilarColor(lighterRgb);
            const satH = hsl[0];
            const satS = Math.min(100, hsl[1] + (i+1) * 10);
            const satL = hsl[2];
            const satRgb = hslToRgb(satH, satS, satL);
            addSimilarColor(satRgb);
        }
    }
    function addSimilarColor(rgb) {
        const hex = rgbToHex(rgb[0], rgb[1], rgb[2]);
        const colorItem = document.createElement('div');
        colorItem.className = 'similar-colors__item';
        colorItem.style.backgroundColor = hex;
        
        const hexLabel = document.createElement('span');
        hexLabel.className = 'similar-colors__hex';
        hexLabel.textContent = hex;
        
        colorItem.appendChild(hexLabel);
        similarColorsGrid.appendChild(colorItem);
        colorItem.addEventListener('click', function() {
            colorInput.value = hex;
            updateColorDisplay(hex);
        });
    }
    function rgbToHex(r, g, b) {
        return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
    }
    
    function rgbToHsl(r, g, b) {
        r /= 255, g /= 255, b /= 255;
        const max = Math.max(r, g, b), min = Math.min(r, g, b);
        let h, s, l = (max + min) / 2;
        
        if (max === min) {
            h = s = 0;
        } else {
            const d = max - min;
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
            
            switch (max) {
                case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                case g: h = (b - r) / d + 2; break;
                case b: h = (r - g) / d + 4; break;
            }
            
            h /= 6;
        }
        
        return [h * 360, s * 100, l * 100];
    }
    
    function hslToRgb(h, s, l) {
        h /= 360;
        s /= 100;
        l /= 100;
        let r, g, b;
        
        if (s === 0) {
            r = g = b = l;
        } else {
            const hue2rgb = (p, q, t) => {
                if (t < 0) t += 1;
                if (t > 1) t -= 1;
                if (t < 1/6) return p + (q - p) * 6 * t;
                if (t < 1/2) return q;
                if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
                return p;
            };
            
            const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
            const p = 2 * l - q;
            
            r = hue2rgb(p, q, h + 1/3);
            g = hue2rgb(p, q, h);
            b = hue2rgb(p, q, h - 1/3);
        }
        
        return [Math.round(r * 255), Math.round(g * 255), Math.round(b * 255)];
    }
});