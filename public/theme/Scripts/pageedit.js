
$(document).ready(function()
{
    $("#showDefpic").click(function()
    {
        $("#defimage").trigger("click");
    });
    
    
    $("#descedit").click(function()
    {
        uid = curUid;
        pid = Curpid;
        desc = $("#description").val();
        $.ajax({
            type: "POST",
            url: Baseurl + "page_edit_description",
            dataType: 'html',
            data: ({uid: uid, pid: pid, desc: desc}),
            success: function(theResponse) {
                jQuery.noticeAdd({
                    text: theResponse,
                    stay: false,
                    type: 'success'
                });
            }
        });

    });

    $("#defimage").click(function()
    {
        var form = document.forms.namedItem("defimgpic"); // high importance!, here you need change "yourformname" with the name of your form
        var formdata = new FormData(form); // high importance!
       
        desc = $("#defimage").val();
        $.ajax({
            async: true,
            type: "POST",
            file:true,
            dataType: "html", // or html if you want...
            contentType: false, // high importance!
            url: Baseurl + 'DefimagePage', // you need change it.
            data: formdata, // high importance!
            processData: false, // high importance!
            success: function(data) {
alert(data);
                //do thing with data....

            },
            timeout: 10000
        });

    });

      $(function() {
       $('img#add').click(function() {
           var i = parseInt($('#fileCount').val());
           i++;
   
           $('<tr><td style="padding-top: 5px;text-align:right;direction:rtl;border:none;overflow: hidden;"><span class="btn btn-default btn-file">فایل<input  type="file" name="file[' + i + ']" onchange="FileName(this);" ></span><span class="descr" style="display:none;"><div class="DelFile icon-hazv" onclick="RemoveFile(this);" style="color: red;cursor: pointer !important;display: inline-block; height: 15px;width: 15px;"></div>  <input name="ftitle[' + i + ']" class="form-control" style="display: inline;max-width: 200px;" value="" /></span>  </td></tr>').appendTo('table#files');
           $('#fileCount').val(i);
       });
        $('img#remove').click(function() {
            var i = parseInt($('#fileCount').val());
            if (i > 1) {
                $('table#files tr:last').remove();
                i--;
            }
        });
    });

    $(".workflow").click(function() {
        $("#datepicker0").hide();
    });
    $("#RadioGroup2_3").click(function() {
        $("#datepicker0").show();
    });
    var totalChars = 156; //Total characters allowed in textarea
    var countTextBox = $('#description') // Textarea input box
    var charsCountEl = $('#charcount'); // Remaining chars count will be displayed here
    charsCountEl.text(totalChars); //initial value of countchars element
    countTextBox.keyup(function() { //user releases a key on the keyboard
        var thisChars = this.value.replace(/{.*}/g, '').length; //get chars count in textarea
        number = totalChars - thisChars;
        charsCountEl.text(number);
        if (number < 0)
            $('#charcount').css('color', 'red');
        else
            $('#charcount').css('color', 'black');
    });
});