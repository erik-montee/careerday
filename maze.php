<html>
<title> Maze Generator </title>
<body>
<?php
if(isset($_POST['grid'])) {
?>
<canvas tabindex='1' id="main" width="600" height="600"> </canvas>
<img src='/assets/star.png' id="avatar" hidden></img>
<script>
var canvas = document.getElementById("main");
var context = canvas.getContext('2d');
var grid = <?php echo $_POST['grid']; ?>;
var colWidth = canvas.width/grid;
var colHeight = canvas.height/grid;
context.fillStyle="white";
context.fillRect(0,0,600,600);
</script>
<script src='js/maze.js'></script>
<p id="timer">0</p>
</body>
</html>
<?php
} else {
?>
<form method='POST'>
<label>Name</label><input type="text" name="name"></input>
<label>Teacher</label><input type="text" name="teacher"></input>
<label> Grid </label> <input name='grid' type='number' min=0></input>
<input type='submit'></input>
</form>
</body>
<?php 
}
?>