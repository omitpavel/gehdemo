jQuery(document).ready(function(e) {
    if (typeof CommonJsFunctionCallAfterContentRefersh == "function") {
        CommonJsFunctionCallAfterContentRefersh();
    }

    var modal_zindex_start_value = 1050;
    $(document).on("show.bs.modal", ".modal", function(event) {
        modal_zindex_start_value = modal_zindex_start_value + 1;
        var modal_zindex_value =
            modal_zindex_start_value + 10 * $(".modal:visible").length;
        $(this).css("z-index", modal_zindex_value);
        setTimeout(function() {
            $(".modal-backdrop")
                .not(".modal-stack")
                .css("z-index", modal_zindex_value - 1)
                .addClass("modal-stack");
        }, 0);
    });
});

$(document).ready(function() {
    $("body .refresh-content").css("display", "inline-block");
    $(".page-loader").hide();
    if (
        typeof CommonJsFunctionCallAfterContentRefershForLoadAnimatedGraph ==
        "function"
    ) {
        CommonJsFunctionCallAfterContentRefershForLoadAnimatedGraph();
    }

    setInterval(function() {
        window.location.reload();
    }, 14200000);

    $(".modal").on("hidden.bs.modal", function(e) {
        if ($(".modal").hasClass("show")) {
            $("body").addClass("modal-open");
        }
    });
});

$(function() {
    $("#responsive_side_nav_trigger").click(function() {
        $("#resposive_left_slide_nav_wrap").toggleClass("active");
    });

    $("#right_nav_trigger_button").click(function() {
        $("#right_side_nav_wrap_Inner_nav").toggleClass("active");
    });


    $(".active_row_remove_cell").on("click", function() {
        $(".overlay_selection_box").css("display", "none");
    });

    $(".drop_down_nav_trigger").on("click", function() {
        $(".check_box_wrapper").toggleClass("show");
    });
});

function DisableSaveButtonLoadImageForModals() {
    $(".loading-save-svg-to-show-on-save").css("display", "none");
    $(".normal-save-svg-to-show-on-save").css("display", "inline-block");
}


function CloseModalAndRemoveBackdrop() {
    $('.modal-backdrop').remove();
    $('.modal').modal('hide');
}

function PermissionDeniedAlert(){
    toastr.error('Permission Restricted');
}

function RemoveBackdrop() {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove();

}
function CommonLoginModalPopupOpenOnRequest() {
    setTimeout(function() {
        if ($(".camis_ward_summary_boardround_sub_inner_popup_common_class").length > 0) {
            $(".camis_ward_summary_boardround_sub_inner_popup_common_class").modal("hide");

        }
        if ($(".offcanvas").length > 0) {
            $(".offcanvas").offcanvas("hide");
        }

        var common_login_modal = new bootstrap.Modal(document.getElementById('permission_modal'));
        common_login_modal.show();
        DisableLoaderAndMakeVisibleInnerBody();
        $('.hide-on-first-load').css("display", "none");
        $('.all_tab_content_loader_image').css("display", "none");
        CommonDisableEnableAfterSave();
    }, 1000);
}

$(document).on("click", ".permission_denied_div", function(
    e) {
    toastr.clear();
    setTimeout(function() {
        toastr.error('Permission Restricted');
    }, 900);
});


function EnableSaveButtonLoadImageForModals() {
    $(".loading-save-svg-to-show-on-save").css("display", "inline-block");
    $(".normal-save-svg-to-show-on-save").css("display", "none");
}

function DisableSaveButtonLoadImageForModals() {
    $(".loading-save-svg-to-show-on-save").css("display", "none");
    $(".normal-save-svg-to-show-on-save").css("display", "inline-block");
}

function EnableDeleteButtonLoadImageForModals() {
    $(".loading-delete-svg-to-show-on-delete").css("display", "inline-block");
    $(".normal-delete-svg-to-show-on-delete").css("display", "none");
}

function DisableDeleteButtonLoadImageForModals() {
    $(".loading-delete-svg-to-show-on-delete").css("display", "none");
    $(".normal-delete-svg-to-show-on-delete").css("display", "inline-block");
}

function EnableSaveButtonForModals() {

    $(".all_modal_save_button_for_js").removeClass(
        "bottom-save-button-disabled"
    );
    $(".all_modal_save_button_for_js").addClass("bottom-save-button");
}

function DisableSaveButtonForModals() {
    $(".all_modal_save_button_for_js").removeClass("bottom-save-button");
    $(".all_modal_save_button_for_js").addClass("bottom-save-button-disabled");
}

function EnableDeleteButtonForModals() {
    $(".all_modal_delete_button_for_js").removeClass(
        "bottom-delete-button-disabled"
    );
    $(".all_modal_delete_button_for_js").addClass("bottom-delete-button");
}

function DisableDeleteButtonForModals() {
    $(".all_modal_delete_button_for_js").removeClass("bottom-delete-button");
    $(".all_modal_delete_button_for_js").addClass(
        "bottom-delete-button-disabled"
    );
}

function HideModalFooterButtonForClick() {
    $(".ibox_modal_footer_button_class_top_to_hide_button").css(
        "display",
        "inline-block"
    );
}

function ShowModalFooterButtonForClick() {
    $(".ibox_modal_footer_button_class_top_to_hide_button").css(
        "display",
        "none"
    );
}

function DisableButtonClickForPreventFurtherEvent(class_name_to_disable) {
    $("." + class_name_to_disable).addClass("button-event-trigger-disabled");
    clear_patient_name_show = setTimeout(function() {
        $("." + class_name_to_disable).removeClass(
            "button-event-trigger-disabled"
        );
    }, 2000);
}

function CommonDisableEnableAfterSave() {
    DisableDeleteButtonLoadImageForModals();
    DisableSaveButtonLoadImageForModals();
    DisableDeleteButtonForModals();
    DisableSaveButtonForModals();
    ShowModalFooterButtonForClick();
}

function CommonDisableEnableOnSave() {
    DisableDeleteButtonLoadImageForModals();
    DisableSaveButtonLoadImageForModals();
    DisableDeleteButtonForModals();
    DisableSaveButtonForModals();
    HideModalFooterButtonForClick();
}

function CommonDisableEnableOnOpen() {
    DisableDeleteButtonLoadImageForModals();
    DisableSaveButtonLoadImageForModals();
    DisableDeleteButtonForModals();
    DisableSaveButtonForModals();
    ShowModalFooterButtonForClick();
    $(".ward_summary_sub_modal_inner_body").css("visibility", "hidden");
    $(".modal-popup-loader-content").show();
}

function EnableLoaderAndMakeHiddenInnerBody() {
    $(".ward_summary_sub_modal_inner_body").css("visibility", "hidden");
    $(".modal-popup-loader-content").show();
}


function DisableLoaderAndMakeVisibleInnerBody() {
    $(".ward_summary_sub_modal_inner_body").css("visibility", "visible");
    $(".modal-popup-loader-content").hide();
}

function CommonErrorModalPopupOpenOnRequest() {
    setTimeout(function() {
        $(".camis_ward_summary_boardround_sub_inner_popup_common_class").modal(
            "hide"
        );
        toastr.warning('Something Went Wrong');
        CommonDisableEnableAfterSave();
    }, 1000);
}

function CommonToHideSubInnerPopupBoardround() {
    var element = $(".camis_ward_summary_boardround_sub_inner_popup_common_class");

    function isElementVisible(el) {
        return el.is(":visible") && el.css("opacity") !== "0" && el.css("display") !== "none";
    }

    if (element.hasClass("modal") && isElementVisible(element)) {
        element.modal("hide");
    }

    if (element.hasClass("offcanvas") && isElementVisible(element)) {
        element.offcanvas("hide");
    }

    $(".alert")
        .fadeTo(500, 0)
        .slideUp(500, function() {
            $(this).remove();
        });
}

function CommonBoardroundSubInnerPopupAlertMessageShow(alert_message) {
    if (alert_message.status == 1) {
        $(".ward_summary_boardround_sub_inner_popup_success_message").html(
            '<div class="ward_summary_boardround_sub_inner_popup_success_message_inner_alert alert alert-success" style="text-align: center;">' +
            alert_message.message +
            "</div>"
        );
    } else {
        $(".ward_summary_boardround_sub_inner_popup_success_message").html(
            '<div class="ward_summary_boardround_sub_inner_popup_success_message_inner_alert alert alert-danger" style="text-align: center;">' +
            alert_message.message +
            "</div>"
        );
    }
}



function CommonErrorModalPopupOpen() {
    $("#common_error_modal_show").modal({
        show: false,
        backdrop: 'static'
    });
    $("#common_error_modal_show").modal("show");
}
function EnableToolTipForAjax() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}


function lower_case(str) {
    return str.toLowerCase();
}
// function CreateAndShowOffcanvas(elementId) {
//     try {
//       const offcanvasElement = document.getElementById(elementId);
//
//       if (!offcanvasElement) {
//         console.error(`Element with ID "${elementId}" not found.`);
//         return;
//       }
//
//       const offcanvas = new bootstrap.Offcanvas(offcanvasElement, {
//         relatedTarget: 'OffcanvasRight',
//         backdrop: true
//       });
//
//
//         function HideOffcanvas() {
//             if (offcanvas._isShown && offcanvasElement) { // Check if offcanvas is open and exists
//                 offcanvas.hide();
//                 const backdrop = document.querySelector('.offcanvas-backdrop');
//                 if (backdrop) {
//                     backdrop.parentNode.removeChild(backdrop);
//                 }
//             }
//         }
//
//
//       function HideOffcanvas() {
//         offcanvas.hide();
//         const backdrop = document.querySelector('.offcanvas-backdrop');
//             if (backdrop) {
//                 backdrop.parentNode.removeChild(backdrop);
//             }
//       }
//
//       offcanvasElement.addEventListener('hidden.bs.offcanvas', function () {
//         HideOffcanvas();
//     });
//       offcanvas.show();
//
//       return HideOffcanvas;
//     } catch (error) {
//       console.error("Error creating offcanvas:", error);
//     }
// }

function CloseOffcanvas(offcanvas_id) {

    var $offcanvasElement = $('#' + offcanvas_id);

    if ($offcanvasElement.hasClass('show')) {
        $offcanvasElement.offcanvas('hide');
        $offcanvasElement.removeClass('show');

        // Check if there are any other offcanvas elements still open
        var anyOtherOffcanvasOpen = $('.offcanvas.show').length > 0;

        if (!anyOtherOffcanvasOpen) {
            $('.offcanvas-backdrop').remove();
            $('body').css({
                'overflow': '',
                'padding': ''
            });
        }

        if ($('.offcanvas-overlay').css('display') === 'block') {
            $('.offcanvas-overlay').css('display', 'none');
        }

        setTimeout(function() {
            $('body').css('overflow', '').css('padding-right', '');
        }, 1000);
    }
}



function PermissionRestricted() {
    toastr.error('Permission Restricted.');
}


$(document).on("click", ".permission_denied_alert", function(
    e) {
    toastr.clear();
    setTimeout(function() {
        toastr.error('Permission Restricted');
    }, 100);
});
function ResponsiveTopButtons(el) {
    $("#moreButtons").toggleClass("d-none");
    if ($("#moreButtons").hasClass("d-none")) {
        $($(el)).html('<i class="bi bi-three-dots-vertical"></i>');
    } else {
        $($(el)).html('<i class="bi bi-x-lg"></i>');
    }
}
function MultiSelectJs(elementId, label) {
    $('#' + elementId).multiselect({
        columns: 1,
        placeholder: '' + label,
        search: true,
        searchOptions: {
            'default': 'Search'
        },
        selectAll: true,
        onOptionClick: function(element, option) {
            updatePlaceholder(elementId, label);
        },
        onControlClose: function(element) {
            updatePlaceholder(elementId, label);
        }
    });

    updateGroupCheckboxStates(elementId);
    updatePlaceholder(elementId, label);
    setTimeout(() => {
        const wrapper = $('#' + elementId).next('.ms-options-wrap');

        wrapper.find('.optgroup-all').off('change').on('change', function () {
            const $group = $(this).closest('.optgroup');
            const isChecked = $(this).is(':checked');
            const $childCheckboxes = $group.find('ul li input[type="checkbox"]').not('.optgroup-all');
            const $select = $('#' + elementId);

            $childCheckboxes.prop('checked', isChecked).trigger('change');

            $childCheckboxes.each(function () {
                const val = $(this).val();
                $select.find(`option[value="${val}"]`).prop('selected', isChecked);
            });

            $select.multiselect('reload');

            $select.trigger('change');

            updateGroupCheckboxStates(elementId);
            updatePlaceholder(elementId, label);
        });
    }, 200);

}
function updateGroupCheckboxStates(elementId) {
    $('#' + elementId).next('.ms-options-wrap').find('.optgroup').each(function () {
        const $group = $(this);
        const $options = $group.find('ul li input[type="checkbox"]').not('.optgroup-all');
        const $groupCheckbox = $group.find('.optgroup-all');

        if ($options.length === 0) return;

        const allChecked = $options.length === $options.filter(':checked').length;

        $groupCheckbox.prop('checked', allChecked);
    });
}

function updatePlaceholder(elementId, label) {
    let selectedCount = $('#' + elementId + ' option:selected').length;
    let placeholderText = '';

    if (selectedCount === 0) {
        placeholderText = '' + label;
    } else if (selectedCount === 1) {
        placeholderText = '1 ' + label + ' Selected';
    } else {
        placeholderText = selectedCount + ' ' + label + 's Selected';
    }

    $('#' + elementId).next('.ms-options-wrap').find('button').html('<span>' + placeholderText + '</span>');
}
