<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>jstree basic demos</title>
	<style>
	html { margin:0; padding:0; font-size:62.5%; }
	body { max-width:800px; min-width:300px; margin:0 auto; padding:20px 10px; font-size:14px; font-size:1.4em; }
	h1 { font-size:1.8em; }
	.demo { overflow:auto; border:1px solid silver; min-height:100px; }
	</style>
<!--	<link rel="stylesheet" href="./../../dist/themes/default/style.min.css" />-->
</head>
<body>
<div id="tree1"></div>
    <script>
            var data = [
        {
            label: 'node1',
            children: [
                { label: 'child1' },
                { label: 'child2' }
            ]
        },
        {
            label: 'node2',
            children: [
                { label: 'child3' }
            ]
        }
    ];

            $(function() {

        $('#tree1').tree({
            data: data
        });
    });
    </script>  
   
</body>
</html>