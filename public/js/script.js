
function previewImage(input) {
	let reader = new FileReader();

    reader.readAsDataURL(input.files[0]);

    reader.onload = function() {
        const imgPath = reader.result;

        var parentDiv = document.getElementById('parentDiv');
        var removeChild = parentDiv.lastChild;
        var addChild = trimImage(imgPath);
        parentDiv.replaceChild(addChild, removeChild);

        function trimImage (imgPath) {

            const TRIM_SIZE = 600;
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
        
            canvas.width = canvas.height = TRIM_SIZE;
            canvas.id = 'canvas-photo';
        
            var img = new Image();
            img.src = imgPath
        
            // imgは読み込んだ後でないとwidth,heightが0
            img.onload = function() {
                // 横長か縦長かで場合分けして描画位置を調整
                var width, height, xOffset, yOffset;
                if (img.width > img.height) {
                    height = TRIM_SIZE;
                    width = img.width * (TRIM_SIZE / img.height);
                    xOffset = -(width - TRIM_SIZE) / 2;
                    yOffset = 0;
                } else {
                    width = TRIM_SIZE;
                    height = img.height * (TRIM_SIZE / img.width);
                    yOffset = -(height - TRIM_SIZE) / 2;
                    xOffset = 0;
                }
                ctx.drawImage(img, xOffset, yOffset, width, height);
            };        
            return canvas;
        }
    };	
}

function updatePost() {
    document.getElementById('updatePostButton').submit();
}

const username = document.getElementById('username');
if(username) {
    username.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            return e.preventDefault();
        }
    });
}

const tags = document.getElementById('tags');
if(tags) {
    tags.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            return e.preventDefault();
        }
    });
}
