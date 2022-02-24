function add_users(baseUrl, id) {
    if (id && id != '') {
        window.location.replace(baseUrl + "user_admin/add/" + id);
    } else {
        window.location.replace(baseUrl + "user_admin/add");
    }

}

function add_data(baseUrl, ctrlName, id, funcName) {
    if (!funcName || funcName === '') {
        funcName = 'add';
    }
    if (id && id != '') {
        window.location.replace(baseUrl + ctrlName + "/" + funcName + "/" + id);
    } else {
        window.location.replace(baseUrl + ctrlName + "/" + funcName);
    }

}

function add_menu(baseUrl, id) {
    if (id && id != '') {
        window.location.replace(baseUrl + "menu/add/" + id);
    } else {
        window.location.replace(baseUrl + "menu/add");
    }

}

function add_content(baseUrl, id) {
    if (id && id != '') {
        window.location.replace(baseUrl + "content/add/" + id);
    } else {
        window.location.replace(baseUrl + "content/add");
    }

}

function delete_data(baseUrl, controllerName, page) {
    if (!page) {
        page = 'index';
    }
    var dataDelete = new Array();
    $(".delcheck").each(function () {
        if ($(this).is(":checked")) {
            var rawData = {
                id: $(this).val()
            };
            dataDelete.push(rawData);
        }
    });

    if (dataDelete.length > 0) {
        var confirmBox = confirm("Anda Yakin ingin menghapus Data ?");
        if (confirmBox == true) {
            $.ajax({
                url: baseUrl + controllerName + "/delete",
                type: "POST",
                dataType: 'json',
                data: {
                    dataDelete: dataDelete

                            //                asrs_data:JSON.stringify(data_tables)
                },
                success: function (data) {
                    if (data['success']) {
                        alert(data['message']);
                        if (data['url'] == '') {
                            window.location.replace(baseUrl + controllerName + "/" + page);
                        } else {
                            window.location.replace(baseUrl + controllerName + '/' + data['url']);
                        }
                    }

                }
            });
        }

    }

}

function auth_edit(baseUrl, groupCode) {
    window.location.replace(baseUrl + "group/auth_edit/" + groupCode);
}

function cancelButton(baseUrl, controller) {
    window.location = baseUrl + controller + "/index";
}

function delrowdata(t) {
    $(t).parent().parent().remove();
}

function export_data(baseUrl, controller) {
    $.ajax({
        url: baseUrl + controller + "/export_csv",
        type: "POST",
        dataType: 'html',
        data: {
//                search:$(obj).val() 
        },
        success: function (data)
        {
        }
    });
}

function autocompleteSearch(baseUrl, controller, obj, elmn) {
    $(obj).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseUrl + controller + "/getAcc",
                type: "POST",
                dataType: "json",
                data: {
                    acc_num: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 6,
        select: function (event, ui) {

            if (ui.item.valuename !== '') {
                $(obj).parent().parent().find('.accname').val(ui.item.valuename);
            }
//            $( "<div>" ).text(ui.item.label).prependTo(obj);
//            $(obj).scrollTop( 0 );
//        log( ui.item ?
//          "Selected: " + ui.item.label :
//          "Nothing selected, input was " + this.value);
        },
        open: function () {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });

    $(obj).autocomplete("option", "appendTo", elmn);
}

function show_password() {
    if ($("#pass").attr('type') === 'password') {
        $("#pass").attr('type', 'text');
    } else if ($("#pass").attr('type') === 'text') {
        $("#pass").attr('type', 'password');
    }
}

function get_report(id, baseUrl, cntlName) {
    var pnumber = 0;

    $.ajax({
        url: baseUrl + cntlName + "/paging",
        type: "POST",
        dataType: 'json',
        data: {limit: $("#limit").val(),
            totaldata: $("#totaldata").val(),
            pnum: pnumber,
            branchfrom: $("#branch_id_from").val(),
            branchto: $("#branch_id_to").val(),
            nobukti: $("#no_bukti").val()
//                spplid:$("#sppl_id").val()
        },
        success: function (data)
        {
            if ($("#" + id).children("tbody").length > 0) {
                $("#" + id + " > tbody").html('');
                $("#" + id + " > tbody").html(data['template']);
            } else {
                $("#" + id + "").html('');
                $("#" + id + "").html(data['template']);
            }

            $("#limit").val(data['limit']);
            $(".pnumber").val(data['pnumber']);
            initPaging();
        }
    });
}

function cetak_excel_report(formName, exportType) {
    var valid = true;
    if (valid) {
        $("#export_type").val(exportType);
        $('#' + formName + '').submit();
    }
}

function add_category(baseUrl, controller, elm) {
    $.ajax({
        url: baseUrl + controller + "/category_list",
        type: "POST",
        dataType: 'json',
        data: {
//                search:$(obj).val() 
        },
        success: function (data)
        {
//            $("#bidang_kerja_list > tbody").html('');
//            $("#istri_add > tbody").append(data['htmldata']);
            if (elm == '') {
                $(data['htmldata']).appendTo('#product_add > tbody');
            } else {
                $(data['htmldata']).appendTo('#' + elm + ' > tbody');
            }


        }
    });
}
function delcategory(t) {
    $(t).parent().parent().remove();
}

function formatRupiah(obj, prefix) {
    var separator;
    var number_string = $(obj).val().replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    $(obj).val(prefix == undefined ? rupiah : rupiah ? rupiah : "");
//  $(obj).val(prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "");
//  return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

function get_category(baseUrl, controller, obj) {
    $.ajax({
        url: baseUrl + controller + "/get_categories",
        type: "POST",
        dataType: 'json',
        data: {
            menuid: $(obj).val()
        },
        success: function (data)
        {
            if (data['htmldata'] !== '') {
                $("#category_add > tbody").html('');
                $(data['htmldata']).appendTo('#category_add > tbody');
            } else {
                $("#category_add > tbody").html('');
            }


        }
    });
}

function make_appointment(prdcid) {
    var valid = true;
    if ($("#order_lctn_id").val() === '') {
        alert("Silahkan Pilih Lokasi.");
        valid = false;
    }
    
    if (valid) {
        $("#form_product_"+prdcid).submit();
    }
}

function add_product_order(baseUrl,controller,elm){
    $.ajax({
        url : baseUrl+controller+"/add_product_order",
        type: "POST",
        dataType:'json',
        data : {
            },
        success: function(data)
        {
            $(data['htmldata']).appendTo('#'+elm+' > tbody');
        }
    });
}

function delproduct(t) {
    $(t).parent().parent().remove();
}

function sum_total_row(obj) {
    var parent = $(obj).parent().closest('tr');
    var totalRow = 0;
    totalRow = parseInt($(obj).val() * parent.children().find(".price_info").val());
    parent.children().find('.total_row').val(totalRow);
    sum_total_all();
}

function get_price(obj) {
    $(obj).parent().closest('tr').children().find(".price_info").val($(obj).find('option:selected').attr('price'));
}

function sum_total_all() {
    var totalPrice = 0;
    $(".total_row").each(function () {
        totalPrice += parseInt($(this).val());
    });
    
    $("#order_cost").val(parseInt(totalPrice));
    $("#order_ppn").val(parseInt(totalPrice) *0.1);
    $("#order_total_cost").val(parseInt($("#order_cost").val()) + parseInt($("#order_ppn").val()));
}