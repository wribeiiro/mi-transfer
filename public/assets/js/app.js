const MESSAGES = {
    success: `<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Arquivos enviados com sucesso!!</div>`,
    warning: (data) => {
        return `<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>${data}</div>`
    },
    info: `<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button>Processando arquivos... <span><strong id="progress"></strong></span> <br></div>`,
    danger: `<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>Ocorreu um erro ao processar arquivos!</div>`,
    validations: {
        warning_files: `<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>Nenhum arquivo selecionado!</div>`,
        warning_emails: `<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>Seu e-mail / de destino são obrigatórios!</div>`,
        warning_filesize: `<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>Arquivos excederam o limite de 2GB</div>`
    }
}

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
    const csrf    = $("#csrf").val()
    const files   = $('#files')[0].files

    if (validateFields(emailFrom, emailTo, files) === false) {
        return
    }

    let formData = new FormData(this)

    formData.append('emailFrom', emailFrom)
    formData.append('emailTo', emailTo)
    formData.append('message', message)
    formData.append('csrf', csrf)
    formData.append("files[]", files)

    $.ajax({
        url: `${BASE_URL}/sendfiles`,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: "POST",
        dataType: "JSON",
        success: (data) => {
            console.log(data)
            if (data.status === 1 && data.data === "OK") {
                $('#resultMessage').html(MESSAGES.success)
                clearFields()
                return
            }

            $('#resultMessage').html(MESSAGES.warning(data.data))
        }, 
        error: (e) => {
            console.log(e)
            if (e.status == 400) {
                alert('aosdk')
                $('#resultMessage').html(MESSAGES.warning(e.responseJSON.data))
                return
            }

            $('#resultMessage').html(MESSAGES.danger)
        },
        beforeSend: (a) => {
            $('#resultMessage').html(MESSAGES.info)
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

function validateFields(emailFrom, emailTo, files) {

    if (!files.length) {
        $('#resultMessage').html(MESSAGES.validations.warning_files)
        return false
    }

    if (!emailFrom || !emailTo) {
        $('#resultMessage').html(MESSAGES.validations.warning_emails)
        return false
    }

    if (getFilesSize(files) > (1000 * 2048)) {
        $('#resultMessage').html(MESSAGES.validations.warning_filesize)
        return false
    }

    return true
}

function getFilesSize(files) {
    let size = 0

    for (let i = 0; i < files.length; i++) {
        size += files[i].size
    }

    return Math.round(size / 1024)
}

function clearFields() {
    $('#selectedFiles').text('')
    $("#emailFrom").val('')
    $("#emailTo").val('')
    $("#message").val('')
    $('#files').val(null)
}
