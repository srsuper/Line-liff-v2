<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>SeeOil Application</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <script>

            function initializeApp(data) {
                var userID = 'U2e0a6d60a5c7df1eca8da371af8fbfc0';
                var groupID = 'Cbe563455d346cacf12ad0ff206eb3d00';
                 if (groupID == null){
                    alert('คุณไม่ได้รับอนุญาติให้เข้าใช้งาน กรุณาติดต่อฝ่ายขาย')
                } else {
                    $.post("test.php",{groupid:groupid},
                    function(data){
                        if (data != null){
                            var groupid = data
                            console.log(groupid)
                                $.post("checkpermissionid.php",{userid:userID},
                                        function(data1){
                                       console.log(data1)   

                                })
                        } else {
                            alert('No data')
                        }
                        
                        
                    })
   
                    }

                    }

            initializeApp()


            
            
        
    </script>
    
    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    
</body>