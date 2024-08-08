<?php
	include "/var/www/html/authentification.php";
	if(auth_checkPass("upload") === false)
	{
		header("Location: /authentification.php?request=upload&request_location=upload");
	}
?>
<style>
    body
    {
        height:100%;
        width:100%;
        margin: 0px;
        background-color: #1E1E1E;
    }
    
    .header
    {
        position:relative;
        top:0px;
        margin: 0px;
        padding-top: 10px;
        width: 100%;
        /*background-color: #49438c;*/
        background-image: linear-gradient(to bottom right, #FEFEFE, #49438c, transparent, transparent, transparent);
        vertical-align: middle;
    }
    h1
    {
        font-family: Helvetica;
        font-weight: bold;
        color: #FEFEFE;
        text-align: center;
        font-size: 3rem;
        padding: 1rem;
 }
    .upload_form_wrapper
    {
        display:block;
        position: relative;
        width: 100%;
        height: auto;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    .file_selector
    {
        display: block;
        width: 30%;
        margin-left:35%;
        font-family: Helvetica;
        vertical-align: middle;
        text-align: center;
        color: #FEFEFE;
    }
    .file_selector::file-selector-button
    {
        display:block;
        text-align: center;
        vertical-align: middle;
        background-color: #FEFEFE;
        color: #555556;
        font-family: Helvetica;
        border: 2px solid #555556;
        height: 3rem;
        width:100%;
        margin-bottom: 0.5rem;
        border-radius: 1rem;
        font-size: 1.5rem;
        font-weight: bold;
    }
    .file_selector::file-selector-button:hover
    {
        background-color: #49438c;
        border: 2px solid #FEFEFE;
        color: #FEFEFE;
    }
    .submit_button
    {
        display: block;
        border: none;
        background-color: #FEFEFE;
        color: #555556;
        font-family: Helvetica;
        font-size: 1.5rem;
        font-weight: bold;
        height: 3rem;
        width: 30%;
        margin-top: 1rem;
        margin-left: 35%;
        border: 2px solid #555556;
        border-radius: 1rem;
        vertical-align: middle;
    }
    .submit_button:hover
    {
        border: 2px solid #FEFEFE;
        background-color: #49438c;
        color: #FEFEFE;
    }
    
    .error
    {
        display:block;
        font-family: Helvetica;
        color: #8c6943;
        font-weight: bold;
        text-align:center;
        /*border-bottom: 1px solid #8c6943;*/
    }
    .success
    {
        display:block;
        font-family: Helvetica;
        /*color: #FEFEFE;*/
        font-weight: bold;
        text-align:center;
        /*border-bottom: 1px solid #49438c;*/
        margin-bottom: 1rem;
    }
    #progress_bar
    {
        background: #FEFEFE;
        color: #49438c;
        margin: 0 auto;
        display: block;
        margin-top: 2rem;
        width: 25%;
        border: 1px solid #555556;
        border-radius: 1rem;
    }
    #progress_bar::-moz-progress-bar
    {
        background-color: #49438c;
    }
    #percent_display
    {
        text-align: center;
        margin-top: 0.25rem;
        color: #FEFEFE;
        font-family: Helvetica;
        font-size: 1rem;
    }
    
    #ratio_display
    {
        text-align: center;
        margin-top: 0.25rem;
        color: #FEFEFE;
        font-family: Helvetica;
        font-size: 1rem;
    }
    
    .file_viewer_wrapper
    {
        width: 100%;
        display:block;
        position: relative;
        margin: 0 auto;
    }
    
    .file_viewer_seperator
    {
        width: 100%;
        height:0.125rem;
        background: linear-gradient(90deg, transparent, #FEFEFE, transparent)
    }
    
    h2
    {
        font-family: Helvetica;
        font-weight: bold;
        color: #FEFEFE;
        text-align: left;
        font-size: 2rem;
        padding: 1rem;
        margin: 0;
    }
    
    .file_entry
    {
        width: 100%;
        border-bottom: 1px dotted #FEFEFE;
        padding: 0.125rem;
        background: transparent;
    }
    
    .file_entry:hover
    {
        background-image: linear-gradient(to right, #49438c, transparent);
    }
    
    a
    {
        margin-left: 2rem;
        text-decoration: none;
        color: #FEFEFE;
        font-family: monospace;
        font-size: 1rem;
    }
    
    .disclaimer
    {
        text-align: center;
        margin-top: 0.25rem;
        color: #FEFEFE;
        font-family: Helvetica;
        font-size: 1rem;
    }
    
</style>
<head>
    <title>Himbier: Datei-Upload </title>
    <link rel="icon" href="/include/media/himbier.png"/>
</head>

<body>
    <div class="grid_left">
        <div class="header">
            <h1> Datei-Upload </h1>
            <div class="disclaimer">
            Maximal 1GB, empfohlen bis zu 200MB
            </div>
        </div>
        <div class="upload_form_wrapper">
            <form  method='post' enctype='multipart/form-data' name="upload_form">
                <input class="file_selector" type='file' name='file' id='file'></input>
                <input class="submit_button" type='submit' value='Upload' name='submit'></input>
                <progress value="0" max="100" id="progress_bar" style="display: none;"></progress>
            </form>
            <div id="percent_display"> </div>
            <div id="ratio_display"></div>
        </div>
        
        <div class="error"></div>
        <div class="success"></div>
    </div>
    
    <div class="grid_right">
        <div class="file_viewer_seperator"></div>
        <div class="file_viewer_wrapper">
            <h2>/uploads</h2>
            <div id="file_viewer" class="file_viewer">

                <?php
                    $files = scandir("/var/www/html/upload/uploads");
                    $file_amt = count($files);
                    
                    for($i = 2; $i < $file_amt-1; $i++)
                    {
                        $filename = $files[$i];
                        echo("<div class='file_entry'><a href='/upload/uploads/".$filename."'>├".$filename."</a></div>");
                    }
                    echo("<div class='file_entry'><a href='/upload/uploads/".$files[$file_amt - 1]."'>└".$files[$file_amt - 1]."</a></div>");
                ?>
            </div>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>

<!-- action="/upload/index.php" -->

