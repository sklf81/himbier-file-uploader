var color_wait = "#ff8a8a";
var color_done = "#8aff8c";
var color_working = "#FEFEFE";

document.forms["upload_form"].onsubmit = function(e){
    e.preventDefault();
    
    let error = document.querySelector(".error");
    let success = document.querySelector(".success");

    document.getElementById("progress_bar").style.display = "block";
    
    let file = this.file.files[0];
    error.innerHTML = "";
    if(!file){
        error.innerHTML = "<div class='error'>ERROR: Keine Datei ausgewählt</div>";
        return false;
    }
    
    let formdata = new FormData();
    formdata.append("file", file);
    
    let http = new XMLHttpRequest();
    http.upload.addEventListener("progress", function(event)
    {
            let mega_byte = 1000000;
            let loaded = (event.loaded/mega_byte).toFixed(2);
            let total = (event.total/mega_byte).toFixed(2);
            let percent = Math.round((loaded / total) * 100);
            document.querySelector("progress").value = percent;
            document.getElementById("percent_display").innerHTML = percent.toString() + "%";
            document.getElementById("ratio_display").innerHTML = loaded.toString() + "MB von " + total.toString() + "MB"; 
            if(total == loaded)
            {
                    success.innerHTML = "Die Datei wird verarbeitet, das Fenster kann geschlossen werden. Vielen Dank!";
                    success.style.color = color_working;
            }
            else
            {
                    success.innerHTML = "Bitte warten!";
                    success.style.color = color_wait;
            }           
    });
    
    http.addEventListener("load", function(){
        if(this.readyState == 4 && this.status == 200){
            success.innerHTML = "Die Datei <em>" +  this.responseText + " </em> wurde erfolgreich hochgeladen.";
            success.style.color = color_done;
        }
    });
    
    http.open("post", "upload.php", true);
    http.send(formdata);
}
