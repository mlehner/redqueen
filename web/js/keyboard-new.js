jQuery(function(){

    $write = jQuery('input:not([type=hidden]), select, textarea').eq(0);
    $write.focus();

    jQuery('input:not([type=hidden]), select, textarea').click(function(){
        $write = jQuery(this);
        $write.focus();
    });

    var SYM = 1;
    var LET = 2;
    var FUN = 3;
    var UP = 0;
    var DOWN = 1;

    var mouseState = null;
    var shiftState = null;
    var capsLockState = null;

    var currentCell = null;

    var cells = [];
    
    var canvas = document.getElementById("keyboard");
    var ctx = canvas.getContext("2d");
    
    var keyboard = [
        // row 1
        [
            [['`', '~'], SYM],
            ['1', LET],
            ['2', LET],
            ['3', LET],
            ['4', LET],
            ['5', LET],
            ['6', LET],
            ['7', LET],
            ['8', LET],
            ['9', LET],
            ['0', LET],
            [['-', '_'], SYM],
            [['=', '+'], SYM],
            ['DELETE', FUN, 88, function() { deleteCharacter(); return true; }]
        ],
        // row 2
        [
            ['TAB', FUN, 88, function() { appendCharacter($write, "\t"); return true; }],
            ['q', LET],
            ['w', LET],
            ['e', LET],
            ['r', LET],
            ['t', LET],
            ['y', LET],
            ['u', LET],
            ['i', LET],
            ['o', LET],
            ['p', LET],
            [['[', '{'], SYM],
            [[']', '}'], SYM],
            [['\\', '|'], SYM]
        ],
        // row 3
        [
            ['CAPS LOCK', FUN, 100, function() { capsLockState = (capsLockState == DOWN) ? UP : DOWN; redrawKeyboard(); return true; }],
            ['a', LET],
            ['s', LET],
            ['d', LET],
            ['f', LET],
            ['g', LET],
            ['h', LET],
            ['j', LET],
            ['k', LET],
            ['l', LET],
            [[';', ':'], SYM],
            [['\'', '"'], SYM],
            ['ENTER', FUN, 83, function() { appendCharacter($write, "\n"); return true; }]
        ],
        // row 4
        [
            ['SHIFT', FUN, 117, function() { shiftState = (shiftState == DOWN) ? UP : DOWN; redrawKeyboard(); return true; }],
            ['z', LET],
            ['x', LET],
            ['c', LET],
            ['v', LET],
            ['b', LET],
            ['n', LET],
            ['m', LET],
            [[',', '<'], SYM],
            [['.', '>'], SYM],
            [['/', '?'], SYM],
            ['SHIFT', FUN, 116, function() { shiftState = (shiftState == DOWN) ? UP : DOWN; redrawKeyboard(); return true; }]
        ],
        // row 5
        [
            [' ', LET, 738]
        ]
    ];

    ctx.font = "bold 14px/45px Tahoma, sans-serif";
    ctx.textAlign = "center"; 
    ctx.textBaseline = "middle";

    (function(){
        var cell;
        var i = 0;
        var ii = 0;
        var row;
        var key;
        var width;
        var x;
        for (i in keyboard)
        {
            row = keyboard[i];
            x = 0;
            y = i*50;
            for (ii in row)
            {
                key = row[ii];
               
                if (key.length > 2)
                    width = key[2];
                else
                    width = 45;

                cell = { 'x': x, 'y': y, 'width': width, 'height': 45, 'key': key, 'highlight': false };

                cells.push(cell);

                x += width + 5;
            }
        }

        redrawKeyboard();
    })();

    function appendCharacter($w, character)
    {
        if ($w.attr('tagName') == 'TEXTAREA') {
            $w.html($write.html() + character);
        } else if ($w.attr('tagName') == 'SELECT') {
            // jump to the first element with the letter
        } else {
            // submit the form
            if (character == "\n") {
                $w.parents('form').eq(0).submit();
            }
            $w.val($w.val() + character);
        }
        $w.focus();
    }

    jQuery('#keyboard').click(function(e){
        var cell = getCell(e);

        if (!cell)
            return;

        var $this = jQuery(this);

	var character;
        if (cell.key[1] == FUN)
        {
            if (cell.key[3]())
                return;
        }
        else if (cell.key[1] == LET)
        {
            character = (shiftState == DOWN || capsLockState == DOWN) ? cell.key[0].toUpperCase() : cell.key[0].toLowerCase();
        }
        else if (cell.key[1] == SYM)
        {
            character = (shiftState == DOWN || capsLockState == DOWN) ? cell.key[0][1] : cell.key[0][0];
        }

        appendCharacter($write, character);

        if (shiftState == DOWN)
        {
            shiftState = UP;
            redrawKeyboard();
        }
    });

    jQuery('#keyboard').mousemove(function(e){
        var cell = getCell(e);

        if (currentCell && currentCell != cell)
            paintCell(currentCell, 0);

        if (cell && mouseState == DOWN)
            paintCell(cell, 1);

        currentCell = cell;
    });

    jQuery('#keyboard').mousedown(function(e){
        mouseState = DOWN;
        
        var cell = getCell(e);

        if (!cell)
            return;

        paintCell(cell, 1);

        currentCell = cell;
    });

    jQuery('#keyboard').mouseup(function(e){
        mouseState = UP;
   
        var cell = getCell(e);

        if (!cell)
            return;

        paintCell(cell, 0);

        currentCell = cell;
    });

    function paintCell(cell, highlight)
    {
        if (cell.key[0] == 'SHIFT' && shiftState == DOWN)
            highlight = 1;

        if (cell.key[0] == 'CAPS LOCK' && capsLockState == DOWN)
            highlight = 1;

        cell.highlight = highlight;

        if (highlight == 1)
            ctx.fillStyle = "#333";
        else
            ctx.fillStyle = "#aaa";

        ctx.clearRect(cell.x, cell.y, cell.width, cell.height);
        ctx.fillRect(cell.x, cell.y, cell.width, cell.height);

        if (highlight == 1)
            ctx.fillStyle = "#fff";
        else
            ctx.fillStyle = "#000";

        var text = '';
        if (cell.key[1] == FUN)
            text = cell.key[0];
        if (cell.key[1] == LET)
            text = (shiftState == DOWN || capsLockState == DOWN) ? cell.key[0].toUpperCase() : cell.key[0].toLowerCase();
        else if (cell.key[1] == SYM)
            text = (shiftState == DOWN || capsLockState == DOWN) ? cell.key[0][1] : cell.key[0][0];

        ctx.fillText(text, cell.x + (cell.width/2), cell.y + 22, cell.width);
    }

    function redrawKeyboard()
    {
       for (i in cells)
       {
            var cell = cells[i];
            paintCell(cell, 0);
       }
    }

    function getCell(e)
    {
        var pos = getPosition(e);

        for (i in cells)
        {
            var cell = cells[i];
            if (pos.x >= cell.x && pos.y >= cell.y && pos.x <= cell.x + cell.width && pos.y <= cell.y + cell.height)
            {
                return cell;
            }
        }
    }

    function getPosition(e)
    {
        var x;
        var y;
        if (e.pageX || e.pageY) {
            x = e.pageX;
            y = e.pageY;
        }
        else {
            x = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            y = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }

        x -= canvas.offsetLeft;
        y -= canvas.offsetTop;

        return { 'x': x, 'y': y };
    }
});

