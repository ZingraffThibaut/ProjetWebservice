$(document).ready(function () {
    $("#donnee").prop('disabled', true);
    $("#content").prop('disabled', true);

    $("#methode").change(function (e) {

        selects = document.getElementById("methode");
        methode = selects.options[selects.selectedIndex].value;
        if (methode == "POST") {
            $("#donnee").prop('disabled', false);
            $("#content").prop('disabled', false);
        } else {
            $("#donnee").prop('disabled', true);
            $("#content").prop('disabled', true);
        }
    })

    $("#valide").click(function (e) {
        url = document.getElementById('url').value;

        donnee = document.getElementById('donnee').value;

        selects = document.getElementById("content");
        content = selects.options[selects.selectedIndex].value;

        selects = document.getElementById("methode");
        methode = selects.options[selects.selectedIndex].value;

        selects = document.getElementById("langue");
        langue = selects.options[selects.selectedIndex].value;
        $.ajax({
            type: "POST",
            url: "Client.php",
            data: { url: url, content: content, methode: methode, langue: langue, donnee: donnee },
            success: function (result) {
                $("#Reponse").html(result);
            }
        });
    });
});
