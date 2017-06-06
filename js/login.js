var errorDisplay = {
    isShown: false,
    show: function() {
        if (!this.isShown) {
            $('#errorContainer').show();
            this.isShown = true;
        }
    },
    hide: function() {
        if (this.isShown) {
            $('#errorContainer').hide();
            this.isShown = false;
        }
    },
    set: function(text) {
        $('#errorContainer').find('#errorMessage').text(text);
        this.show();
    }    
}

$(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();
        
        var actionurl = e.currentTarget.action;
        
        var data = $("#loginForm :input").serializeArray();
        
        $.ajax({
                url: actionurl,
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(data) {
                    if (data['error'] == 'no') {
                        errorDisplay.hide();
                        window.location.href = "administration.php";
                    }
                    else {
                        errorDisplay.set(data['error']);
                    }
                }
        }).fail(function(data,txt,err) {
            errorDisplay.set('Prijava nije uspjela. Pokušajte ponovno.'); 
            console.log('Server: ' + data.responseText + '; Klijent: ' + txt + ')\n');
        });
    });
});