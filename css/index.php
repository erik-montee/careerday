<html>
<title> Maze Generator </title>
<body>
<?php
if(isset($_POST['grid'])) {
?>
<canvas tabindex='1' id="main" width="600" height="600"> </canvas>
<img src='/assets/star.png' id="avatar" hidden></img>
<script>
function avatar(x,y,imagex,imagey){
	this.img = document.getElementById('avatar');
	this.cellX = x;
	this.cellY = y;
	this.imagex = imagex;
	this.imagey = imagey;
}

function cell(x,y,row,col,gridNumber,status = null){
	this.x = x;
	this.y = y;
    this.row = row;
    this.col = col;
	this.status = status;
	this.visited = 0;
    this.gridNumber = gridNumber;
}

//remove grid lines
function clearTop(cell1){
    context.clearRect(cell1.x+1,cell1.y-2,colWidth-2,3);
}

function clearBottom(cell1){
    context.clearRect(cell1.x+2,cell1.y+colHeight-2,colWidth-2,3);
}

function clearRight(cell1){
context.clearRect(cell1.x+colWidth-2,cell1.y,3,colHeight-2);
}

function clearLeft(cell1){
context.clearRect(cell1.x-2,cell1.y,3,colHeight-2);
}

var canvas = document.getElementById("main");

var context = canvas.getContext('2d');
var grid = <?php echo $_POST['grid']; ?>;
var colWidth = canvas.width/grid;
var colHeight = canvas.height/grid;

//array of cells
var cellArray = [];
var x = 0;
var z = 0;
for(x; x < grid; x++){
	var y = 0;
    for(y; y < grid; y++) {
        cellArray[z] = new cell(colWidth*x,colHeight*y, y, x, z);
        //context.fillText(z,cellArray[z].x,cellArray[z].y+colHeight/2);
        z++;

    }
}
//load vertical lines
x=0;
for (x; x <= grid; x++) {
context.beginPath();
context.moveTo(colWidth*x,0);
context.lineTo(colWidth*x,canvas.height);
context.stroke();
}

//load horizontal lines
var y=0;
for (y; y <= grid; y++) {
context.beginPath();
context.moveTo(0,colHeight*y);
context.lineTo(canvas.width,colHeight*y);
context.stroke();
}

console.log(cellArray);
//get random starting cell

var randomCell = Math.floor(Math.random()*grid*grid);
var startingCell = cellArray[randomCell];
startingCell.status = 'current';
console.log(startingCell);

//cellArray[startingCell.gridNumber - 1].visited = 1;
//build path
currentCell = startingCell;
var cellVisitedOrder = [];
var p = 0;
cellVisitedOrder[p] = currentCell;
while (currentCell != 0) {
//while (!isEmpty(currentCell) || p != 100){
var surroundingCells = [];
var nonVisitiedCells = [];
var nextPossibleCells = [];

//set currentCell to visited
cellArray[currentCell.gridNumber].visited = 1;

//grab the surrounding cells
if(currentCell.col != 0) {
    leftCell = cellArray[currentCell.gridNumber - grid];
    surroundingCells.push(leftCell);
}
if(currentCell.row != 0) {
    topCell = cellArray[currentCell.gridNumber - 1];
    surroundingCells.push(topCell);
}
if(currentCell.row != grid-1) {
    bottomCell = cellArray[currentCell.gridNumber + 1];
    surroundingCells.push(bottomCell);
}
if(currentCell.col != grid-1) {
    rightCell = cellArray[currentCell.gridNumber + grid];
    surroundingCells.push(rightCell);
}

//Check to see if cells have been visited
surroundingCells.forEach(function(cell){
    if( cell.visited == 0) {
        nonVisitiedCells.push(cell);
    }
});

//decide where to go next
if(nonVisitiedCells.length == 0) {
    nextCell =  cellVisitedOrder[p-1];
    p = p-1;
} else {
    p++;
    //console.log(nonVisitiedCells.length);
    //console.log(Math.floor(Math.random()*(nonVisitiedCells.length)) );
    //console.log(Math.floor(Math.random()*(nonVisitiedCells.length -1)))
    nextCell = nonVisitiedCells[Math.floor(Math.random()*(nonVisitiedCells.length))];
    cellVisitedOrder[p] = nextCell;
    if(cellVisitedOrder[p].gridNumber - cellVisitedOrder[p-1].gridNumber == -1){
        console.log("move up");
        clearTop(cellVisitedOrder[p-1]);
        //nextCell = "";
    }
    if(cellVisitedOrder[p].gridNumber - cellVisitedOrder[p-1].gridNumber == 1){
        console.log("move down");
        clearBottom(cellVisitedOrder[p-1]);
    }
    if(cellVisitedOrder[p].gridNumber - cellVisitedOrder[p-1].gridNumber == grid){
        console.log("move Right");
        clearRight(cellVisitedOrder[p-1]);
    }
    if(cellVisitedOrder[p].gridNumber - cellVisitedOrder[p-1].gridNumber == -grid){
        console.log("move Left");
        clearLeft(cellVisitedOrder[p-1]);
    }
    //console.log(nextCell);
}


if (isEmpty(nextCell)){
currentCell = 0;
} else {
    currentCell = nextCell;
}

//console.log("cellVisited");
//console.log(cellVisitedOrder);
//console.log("surrounding");
//console.log(surroundingCells);
//console.log("non visited");
//console.log(nonVisitiedCells);
//console.log("next cell");
//console.log(nextCell);
}

//load sprite
var avatar = new avatar(0,0,colWidth/4,colHeight/4)
context.drawImage(avatar.img,avatar.imagex,avatar.imagey,colHeight/2,colWidth/2);

//movement
canvas.addEventListener( "keydown", doKeyDown, true);

function doKeyDown(e) {
	//right
    if(39 === e.keyCode ){
    	if (avatar.cellX <= canvas.width - (colWidth*1.1)) {
            context.clearRect(avatar.cellX+1,avatar.cellY+1,colWidth-2,colHeight-2);
            avatar.cellX = avatar.cellX + colWidth;
            avatar.imagex = avatar.imagex + colWidth;
            context.drawImage(avatar.img,avatar.imagex,avatar.imagey,colHeight/2,colWidth/2);
        }
    }
    //left
    if(37 === e.keyCode ){
    	if (avatar.cellX > 0) {
            context.clearRect(avatar.cellX+1,avatar.cellY+1,colWidth-2,colHeight-2);
            avatar.cellX = avatar.cellX - colWidth;
            avatar.imagex = avatar.imagex - colWidth;
            context.drawImage(avatar.img,avatar.imagex,avatar.imagey,colHeight/2,colWidth/2);
        }
    }
    //up
    if(38 === e.keyCode ){
    	if (avatar.cellY > 0) {
            context.clearRect(avatar.cellX+1,avatar.cellY+1,colWidth-2,colHeight-2);
            avatar.cellY = avatar.cellY - colHeight;
            avatar.imagey = avatar.imagey - colHeight;
            context.drawImage(avatar.img,avatar.imagex,avatar.imagey,colHeight/2,colWidth/2);
        }
    }
    //down
    if(40 === e.keyCode ){
    	if (avatar.cellY <= canvas.height - (colHeight*1.1)) {
            context.clearRect(avatar.cellX+1,avatar.cellY+1,colWidth-2,colHeight-2);
            avatar.cellY = avatar.cellY + colHeight;
            avatar.imagey = avatar.imagey + colHeight;
            context.drawImage(avatar.img,avatar.imagex,avatar.imagey,colHeight/2,colWidth/2);
        }
    }
    //console.log(avatar);

}

function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

</script>
</body>
</html>
<?php
} else {
?>
<form method='POST'>
<label> Grid </label> <input name='grid' type='number'</input>
<input type='submit'></input>
</form>
</body>
<?php 
}
?>