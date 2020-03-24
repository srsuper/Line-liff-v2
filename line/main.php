<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeeOil Application</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    
    <div class="buttongroup">
        <div class="buttonrow">
            <a href='inventory.php'><button>น้ำมันคงเหลือ</button></a>
            <a href='inventory.php'><button>การแจ้งเตือน</button></a>
            <a href='inventory.php'><button>รายงานการรับน้ำมัน</button></a>
        </div>
        <br>
        <div class="buttonrow">
            <a href='inventory.php'><button>รายงานยอดขาย</button></a>
            <a href='inventory.php'><button>ยอดเคลื่อนไหวประจำกะ</button></a>
            <a href='inventory.php'><button>สถานะสมาชิก</button></a>
        </div>
    </div>
    

    

    <div id="liffdata">
        <h2>LIFF Data</h2>
        <table border="1">
            
            <tr>
                <th>context.userId</th>
                <td id="useridfield"></td>
            </tr>
            
            
            <tr>
                <th>context.groupId</th>
                <td id="groupidfield"></td>
            </tr>
        </table>
    </div>
    
    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    <script src="liff-starter.js"></script>
</body>