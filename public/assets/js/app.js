$('#files').on('change', function(e) {
    let length = $('#files')[0].files.length;

    $('#selectedFiles').text('')

    if (length) {
        $('#selectedFiles').text(length + ' arquivo(s) selecionado(s)')
    }
})

$("#sendFiles").click(function () {
    $("#formFiles").submit()
})

$("#formFiles").on("submit", function(e) {
    e.preventDefault();

    const emailFrom = $("#emailFrom").val()
    const emailTo = $("#emailTo").val()
    const message = $("#message").val()

    const formData = new FormData(this)
    const files     = $('#files')[0].files

    if (!files.length) {
        $('#resultMessage').html(`
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">×</button>
                Nenhum arquivo selecionado!
            </div>
        `)

        return
    }

    if (!emailFrom || !emailTo) {
        $('#resultMessage').html(`
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">×</button>
                Seu e-mail / de destino são obrigatórios!
            </div>
        `)

        return
    }
    
    formData.append('emailFrom', emailFrom)
    formData.append('emailTo', emailTo)
    formData.append('message', message)
    formData.append("files[]", files)

    const clearFields = () => {
        $('#selectedFiles').text('')
        $("#emailFrom").val('')
        $("#emailTo").val('')
        $("#message").val('')
        $('#files').val(null)
    }
    
    $.ajax({
        url: `${BASE_URL}/sendFiles`,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: "POST",
        dataType: "JSON",
        success: (data) => {
            console.log(data)

            if (data.status = 1) {
                $('#resultMessage').html(`
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        Arquivos enviados com sucesso!!
                    </div>
                `)

                clearFields()
            } 
        }, 
        error: (e) => {
            console.log(e)

            $('#resultMessage').html(`
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Ocorreu um erro ao processar arquivos!
                </div>
            `)
        },
        beforeSend: (a) => {
            $('#resultMessage').html(`
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Processando arquivos... <span><strong id="progress"></strong></span> <br>
                </div>
            `)
        },
        xhr: function() {
            const myXhr = $.ajaxSettings.xhr()
                
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const max     = e.total
                        const current = e.loaded
                        const percent = (current * 100) / max
                
                        $("#progress").html(`${parseInt(percent)}%`)
                    } 
                }, false)
            }

            return myXhr
        }
    })

    return false
})