function closeAllModalPanes() {
    $('.modal-pane-container.active').each(function (ix,el){
        $(el).toggleModalPane(false, true);
    });
}

function isMobile() {
    var app = getAppData();
    if (app.forceMobile) {
        return true;
    }
    var check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
}

function bootstrapMobile() {
    var app = getAppData();


    if (isMobile() && app.improvements) {
        var rSearch = $('#id_resumo_search');
        var rSearchTr = rSearch.parent('tr');
        var rRefinedSearch = $('.scGridRefinaedSearchPadding');
        var rDynamicSearch = $('#NM_Dynamic_Search');
        var rOrder = $('#sc_id_order_campos_placeholder_top');
        var rSaveSearchT = $('#Salvar_filters_top').parent().parent();
        var rSaveSearch = $('#Salvar_filters_bot').parent().parent();
        var rSaveGridT = $('#sc_id_save_grid_placeholder_top');
        var rSaveGrid = $('#sc_id_save_grid_placeholder_top');
        var rColumns = $('#sc_id_sel_campos_placeholder_top');
        var rGroupBy = $('#sc_id_groupby_placeholder_top');
        var rGridDet = $('#sc_grid_det');

        $('body').append('<div id="sc-id-custom-container"></div>');
        $('#sc-id-custom-container').append($('#sc-id-custom-summ-div, #sc-id-custom-groupby-div'));
        var rChartConf = $('#sc-id-custom-container');

        var appendTo = 'body';
        var bodyClass = 'scGridPage';
        var headerClass = 'scGridHeader';
        var toolbarClass = 'scGridToolbar';
        var toolbarPaddingClass = 'scGridToolbarPadding';

        switch (app.appType) {
            case 'form':
                appendTo = 'form[name="F1"]';
                bodyClass = 'scFormPage';
                headerClass = 'scFormHeader';
                toolbarClass = 'scFormToolbar';
                toolbarPaddingClass = 'scFormToolbarPadding';
                break;
        }

        var toggleHandler = function (e) {
            toggleToolbar();
            $('#__mp_' + e.data.baseID).toggleModalPane(true);
            e.data.options.onOpen($('#' + e.data.baseID + '.modal-pane-content'), e.data.openButton, e.data.closeButton);
        };

        if (rOrder) rOrder.openInModalPane({
            openingButton: '#ordcmp_top',
            paneTitleText: $('#ordcmp_top').html(),
            onClose: function (paneContent, openButton, closeButton) {
                var restoreBtn = paneContent.find('#Brestore_ord');
                $(restoreBtn).click();
            },
            onOpen: function (paneContent, openButton, closeButton) {
                var btnID = 'applyBtnOrdFields';
                if (!$('#' + btnID)[0]) {
                    var applyBtn = paneContent.find('#f_sel_sub');
                    // paneContent.find('#f_sel_sub').attr('style', 'display: none !important');
                    // paneContent.find('#Bsair').attr('style', 'display: none !important');
                    // paneContent.find('.scAppDivToolbar').append('<a id="' + btnID + '" class="' + applyBtn.attr('class') + '" title="' + applyBtn.attr('title') + '" style="display:inline-block;">' + applyBtn.html() + '</a>');
                    // $('#' + btnID).on('mousedown.replaceClick', function () {
                    //     scSubmitOrderCampos('top', 'cmp').then(function () {
                    //         closeButton.click();
                    //     })
                    //     paneContent.find('table').attr('style', 'table-layout: fixed');
                    //     paneContent.find('table td').attr('style', 'height: 1px');
                    //     paneContent.find('table td ul').attr('style', 'height: 100%');
                    //     paneContent.find('select').on('touchstart.preventLeak', function(e){ e.stopPropagation(); return true; });
                    //     paneContent.find('select').on('touchend.preventLeak', function(e){ e.stopPropagation(); return true; });
                    // });
                    paneContent.find('.scAppDivContent table table').attr('style', 'table-layout: fixed');
                    paneContent.find('.scAppDivContent table table tr').attr('style', 'display: flex; position: relative;');
                    paneContent.find('.scAppDivContent table table td').attr('style', 'height: auto; display: flex; flex-direction: column; width: 50%; flex-grow: 1;');
                    paneContent.find('.scAppDivContent table table td ul').attr('style', 'height: 100%; flex-grow: 1; min-height: 50vh;');
                    paneContent.find('.scAppDivContent table select').on('touchstart.preventLeak', function(e){ e.stopPropagation(); return true; });
                    paneContent.find('.scAppDivContent table select').on('touchend.preventLeak', function(e){ e.stopPropagation(); return true; });
                    var cancelBtn = paneContent.find('#Bsair_ord');
                    cancelBtn.attr('onclick', '');
                    cancelBtn.off('click');
                    cancelBtn.off('mousedown.replaceClick');
                    cancelBtn.on('mousedown.replaceClick', function teste(e) {
                        closeButton.click();
                    })
                }
            },
            // beforeReady: function (paneContent, openButton, closeButton) {
            //     openButton.click();
            // },
            execClickBeforeReady: true,
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            toggleHandler: toggleHandler
        });
        if (rColumns) rColumns.openInModalPane({
            openingButton: '#selcmp_top',
            paneTitleText: $('#selcmp_top').html(),
            onClose: function (paneContent, openButton, closeButton) {
                var restoreBtn = paneContent.find('#Brestore_sel');
                $(restoreBtn).click();
            },
            onOpen: function (paneContent, openButton, closeButton) {
                var btnID = 'applyBtnSelFields';
                if (!$('#' + btnID)[0]) {
                    var applyBtn = paneContent.find('#f_sel_sub_sel');
                    var cancelBtn = paneContent.find('#Bsair');
                    cancelBtn.attr('onclick', '');
                    cancelBtn.off('click');
                    cancelBtn.off('mousedown');
                    cancelBtn.off('mousedown.replaceClick');
                    cancelBtn.on('mousedown.replaceClick', function (e) {
                        closeButton.click();
                    })
                }
            },
            // beforeReady: function (paneContent, openButton, closeButton) {
            //     openButton.click();
            // },

            execClickBeforeReady: true,
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            toggleHandler: toggleHandler
        });
        if (rDynamicSearch) rDynamicSearch.openInModalPane({
            openingButton: '#dynamic_search_t',
            paneTitleText: $('#dynamic_search_t').html(),
            holdAjax: true,
            onClose: function (paneContent, openButton, closeButton) {
                // var restoreBtn = paneContent.find('#dyn_search_clear');
                // $(restoreBtn).click();
            },
            onReady: function (paneContent, openButton, closeButton) {
                var applyBtn = paneContent.find('#dyn_search');
                var cancelBtn = paneContent.find('#dyn_cancel');
                var closeArrow = paneContent.find('#nm_close_dyn');
                closeArrow.hide();
                cancelBtn.attr('onclick', '');
                cancelBtn.off('click');
                cancelBtn.off('mousedown');
                cancelBtn.off('mousedown.replaceClick');
                cancelBtn.on('mousedown.replaceClick', function (e) {
                    closeButton.click();
                });
                applyBtn.off('mousedown.replaceClick');
                applyBtn.on('mousedown.replaceClick', function (e) {
                    closeButton.click();
                });
            },
            beforeReady: function (paneContent, openButton, closeButton) {
                openButton.click();
            },
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            toggleHandler: toggleHandler
        });
        if (rGroupBy) rGroupBy.openInModalPane({
            openingButton: '#sel_groupby_top',
            paneTitleText: $('#sel_groupby_top').html(),
            holdAjax: false,
            onClose: function (paneContent, openButton, closeButton) {
                var restoreBtn = paneContent.find('#Brestore_gb');
                $(restoreBtn).click();
            },
            onReady: function (paneContent, openButton, closeButton) {
                var applyBtn = paneContent.find('#f_sel_sub_gb');
                var cancelBtn = paneContent.find('#Bsair_gb');
                cancelBtn.attr('onclick', '');
                cancelBtn.off('click');
                cancelBtn.off('mousedown');
                cancelBtn.off('mousedown.replaceClick');
                cancelBtn.on('mousedown.replaceClick', function (e) {
                    closeButton.click();
                });
            },
            beforeReady: function (paneContent, openButton, closeButton) {
                //if (app.appType !== 'summary')
                openButton.click();
            },
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            preserveClick: true,
            toggleHandler: toggleHandler,
            onOpen: function (paneContent, openButton, closeButton) {
                _process(function () { return typeof paneContent.find('#Bsair_gb')[0] !== 'undefined'; }, true).then(function() {
                    var cancelBtn = paneContent.find('#Bsair_gb');
                    cancelBtn.attr('onclick', '');
                    cancelBtn.off('click');
                    cancelBtn.off('mousedown');
                    cancelBtn.off('mousedown.replaceClick');
                    cancelBtn.on('mousedown.replaceClick', function (e) {
                        closeButton.click();
                    });
                });
            }
        });
        if (rSaveGridT) rSaveGridT.openInModalPane({
            openingButton: '#save_grid_top',
            paneTitleText: '',
            beforeReady: function (paneContent, openButton, closeButton) {
                scBtnSaveGridShow('cons', 'Y', 'top');
            },
            onOpen: function (paneContent, openButton, closeButton) {
                var cancelBtn = paneContent.find('#Bsair');
                cancelBtn.attr('onclick', '');
                cancelBtn.off('click');
                cancelBtn.off('mousedown');
                cancelBtn.off('mousedown.replaceClick');
                cancelBtn.on('mousedown.replaceClick', function (e) {
                    closeButton.click();
                });
                paneContent.find('#sc_id_save_grid_placeholder_top').css({
                    'display': 'block'
                });
                //paneContent.find('#Bsair').remove();
                $(document).off('updatefilter');
                $(document).on('updatefilter', function() {
                    paneContent.find('#Bsair').remove();
                    closeButton.click();
                });
            },
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            // execClickBeforeReady: true,
            toggleHandler: toggleHandler
        });
        if (rSaveGrid) rSaveGrid.openInModalPane({
            openingButton: '#save_grid_bot',
            paneTitleText: '',
            onReady: function (paneContent, openButton, closeButton) {
                var cancelBtn = paneContent.find('#Bsair');
                cancelBtn.attr('onclick', '');
                cancelBtn.off('click');
                cancelBtn.off('mousedown');
                cancelBtn.off('mousedown.replaceClick');
                cancelBtn.on('mousedown.replaceClick', function (e) {
                    closeButton.click();
                });
                paneContent.find('#sc_id_save_grid_placeholder_bot').css({
                    'display': 'block'
                });
                //paneContent.find('#Bsair').remove();
                $(document).off('updatefilter');
                $(document).on('updatefilter', function() {
                    paneContent.find('#sc_id_save_grid_placeholder_bot').css({
                        'display': 'block'
                    });
                    paneContent.find('#Cancel_frm_bot').remove();
                    closeButton.click();
                });
            },
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            toggleHandler: toggleHandler
        });
        if (rChartConf) rChartConf.openInModalPane({
            openingButton: '#chart_custom_top',
            paneTitleText: $('#chart_custom_top').text(),
            onReady: function (paneContent, openButton, closeButton) {
                paneContent.append('<div style="padding: 20px;"><button class="scButton_check"><i class="icon_fa fas fa-check"></i> ok</button></div>');
                paneContent.find('.scButton_check').click(function() {closeButton.click();});
            },
            execClickBeforeReady: true,
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            toggleHandler: toggleHandler
        });
        if (rSaveSearch) rSaveSearch.openInModalPane({
            openingButton: '#Ativa_save_bot',
            paneTitleText: '',
            onReady: function (paneContent, openButton, closeButton) {
                paneContent.find('#Salvar_filters_bot').css({
                    'display': 'block'
                });
                paneContent.find('#Cancel_frm_bot').remove();
                $(document).off('updatefilter');
                $(document).on('updatefilter', function() {
                    paneContent.find('#Salvar_filters_bot').css({
                        'display': 'block'
                    });
                    paneContent.find('#Cancel_frm_bot').remove();
                    closeButton.click();
                });
            },
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            beforeReady: function (paneContent, openButton, closeButton) {
                openButton.click();
            },
            toggleHandler: toggleHandler
        });
        if (rSaveSearchT) rSaveSearchT.openInModalPane({
            openingButton: '#Ativa_save_top',
            paneTitleText: '',
            onReady: function (paneContent, openButton, closeButton) {
                paneContent.find('#Salvar_filters_top').css({
                    'display': 'block'
                });
                paneContent.find('#Cancel_frm_top').remove();
                $(document).off('updatefilter');
                $(document).on('updatefilter', function() {
                    paneContent.find('#Salvar_filters_top').css({
                        'display': 'block'
                    });
                    paneContent.find('#Cancel_frm_top').remove();
                    closeButton.click();
                });
            },
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            toggleHandler: toggleHandler
        });
        if($(rRefinedSearch).length && $(rRefinedSearch).html().length>10)
        {
            rRefinedSearch.openInModalPane({
                holdAjax: true,
                openingButton: function(options_in, baseID_in) {
                    $('#sc_grid_body').prepend(' <div id="ref_search_btn_bar" class="scAppDivMoldura"><a class="" id="__mp_button_' + baseID_in + '" style="vertical-align: middle; display: block; text-align: right;"><i class="fas fa-search"></i> ' + options_in.paneTitleText + '</a></div>');
                    return '#__mp_button_' + baseID_in;
                },
                paneTitleText: app.langs['lang_refined_search'],
                onReady: function (paneContent, openButton, closeButton) {
                    var optClass = 'scGridRefinedSearchCampo';
                    $('.dn-expand-button').click()
                },
                appendTo: appendTo,
                bodyClass: bodyClass,
                headerClass: headerClass,
                toolbarClass: toolbarClass,
                toolbarPaddingClass: toolbarPaddingClass,
                toggleHandler: toggleHandler
            });
        }
        if (rSearch) rSearch.openInModalPane({
            openingButton: function(options_in, baseID_in) {
                $('#main_table_res .scGridBorder').prepend(' <div id="sum_search_btn_bar" class="scAppDivMoldura"><a class="" id="__mp_button_' + baseID_in + '" style="vertical-align: middle; display: block; text-align: right;"><i class="fas fa-search"></i> ' + options_in.paneTitleText + '</a></div>');
                return '#__mp_button_' + baseID_in;
            },
            holdAjax: true,
            paneTitleText: app.langs['lang_summary_search_button'],
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            toggleHandler: toggleHandler
        });
        if (rSearchTr) rSearchTr.remove();
        if (rGridDet) rGridDet.openInModalPane({
            openingButton: true,
            paneTitleText: app.langs['lang_details_button'],
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            toggleHandler: toggleHandler
        });
        if (!$('.scAjaxDiv')[0]) appendNavBar();
        if (app.displayScrollUp) appendScrollButton();
        $('#sc-id-mobile-out').remove();
        appendScrollBodyEvents();
        specificStyle();
        toolbarPlacement();
        toolbarSpecificButtonBehaviour();
        applySiteScroll();
        nm_topFrameRun('grab2Scroll');

        if (typeof scSetFixedHeaders == 'function') { scSetFixedHeaders(); }
        closeAllModalPanes();
        history.pushState(null, null, ' ');
        moveWithTouch($('.SC_SubMenuApp'));
        replaceThickBox({
            appendTo: appendTo,
            bodyClass: bodyClass,
            headerClass: headerClass,
            toolbarClass: toolbarClass,
            toolbarPaddingClass: toolbarPaddingClass,
            toggleHandler: toggleHandler
        });
        handlePopState();
        _process(function () {}, 2000).then(function () {
            $('.'+toolbarClass).find('a').removeClass('selected');

            $(document).on( 'DOMNodeInserted', ".select2-results", function(el){
                $(".select2-results").css("visibility","hidden");
                setTimeout(function(){ $(".select2-results").css("visibility","visible"); }, 200);
            } );
        });
        if (typeof nm_cancel_new_grid === 'function' && typeof $nm_cancel_new_grid !== 'function') {
            window.$nm_cancel_new_grid = nm_cancel_new_grid;
            window.nm_cancel_new_grid = function () {
                var keep_panel = true;
                var replace_cancel_btn = true;
                var fn_action_cancel = function (a,b) {
                    if (!a) {
                        parent.close();
                    }
                };
                fn_action_cancel(keep_panel, replace_cancel_btn);
                $nm_cancel_new_grid();
            }
        }
        if (typeof nmAjaxProcOn === 'function' && typeof $nmAjaxProcOn !== 'function') {
            app.procStarted = false;
            window.$nmAjaxProcOn = nmAjaxProcOn;
            window.$nmAjaxProcOff = nmAjaxProcOff;
            window.nmAjaxProcOn = function () {
                console.log('Ajax Interception...');
                if (app.procStarted) {
                    return true;
                }
                app.procStarted = true;
                if ($('.modal-pane-container.active')[0]) {
                    if (!$('.modal-pane-container.active[nm-modalpane-holdajax]')[0]) {
                        window.history.back();
                    }
                }
                $nmAjaxProcOn();
            };
            window.nmAjaxProcOff = function () {
                if (!app.procStarted) {
                    return true;
                }
                app.procStarted = false;
                if (app.appType === 'summary') {
                    _process(function () {}).then(function () {
                        if (app.displayScrollUp) appendScrollButton();
                        appendScrollBodyEvents();
                    });
                }
                $nmAjaxProcOff();
            };
        }

        if (typeof FusionCharts !== 'undefined') {
            FusionCharts.addEventListener('renderComplete', function() {
                $('#res_chart_table span:not(.fusioncharts-container, :only-child)')
                    .addClass('scButton_default')
                    .css({
                        display: 'inline-block',
                        height: '',
                        width: '',
                        background: '',
                        border: '',
                        padding: '',
                        'font-family': '',
                        'font-size': '',
                        'font-weight': '',
                        right: '',
                        left: '0px',
                        color: ''
                    });
            });
        }

        // history.go(0);
    } else {
        $('body').addClass('ready');
    }
}

function appendNavBar() {
    var app = getAppData();
    var btn = '' +
        '<div id="mobile-navbar" class="scGridHeader scGridHeaderFont">' +
            '<input id="mnv-first" />' +
            '<input id="mnv-previous" />' +
            '<input id="mnv-next" />' +
            '<input id="mnv-last" />' +
        '</div>';


    $('#sc_grid_toobar_bot').css({
        padding: '0px',
        display: 'flex',
        'flex-direction': 'row',
        'justify-content': 'center',
        'justify-items': 'center',
        'align-items': 'center',
        position: 'fixed',
        bottom: '0',
        left: '0',
        width: '100%'
    });
    var height = '55px';
    if (app['navigationBarButtons'] && app['navigationBarButtons'].includes('sys_format_rows')) {
        var height = '75px';
    }
    $('#sc_grid_toobar_bot > table').css({
        padding: '0 0 9px 0',
        display: 'flex',
        'flex-direction': 'row',
        'justify-content': 'center',
        'justify-items': 'center',
        'align-items': 'flex-end',
        position: 'relative',
        width: '100%',
        height: height
    });
    $('#sc_grid_toobar_bot > table').find('tr, td, table, tbody').css({
        padding: '0px',
        display: 'block',
        width: '100%',
    });
    //$('#sc_grid_toobar_bot').find('.scGridToolbarPadding:first-child, .scGridToolbarPadding:nth-child(3)').remove();
    $('#sc_grid_toobar_bot > table').find('.scGridToolbarPadding').css({
        padding: '0px',
        display: 'flex',
        'flex-direction': 'row',
        'justify-content': 'center',
        'justify-items': 'center',
        'align-items': 'center',
        width: '100%'
    });
}

function handlePopState() {
    window.stateInitialCount = history.length;
    $(window).off('popstate.panelState');
    $(window).on('popstate.panelState', function(e, d) {
        // closeAllModalPanes();
        e.preventDefault();
        e.stopPropagation();
        console.log(e);
        $('.modal-pane-container.active').toggleModalPane(false, true);
        // closeAllModalPanes();
        if (e.state !== null && e.state !== '') {
            $('#' + e.state).toggleModalPane(undefined, true);
        }



        var url = location.href;
        if (false) {
            if (url.substr('#') === -1) {
                e.preventDefault();
                e.stopPropagation();
                $('.modal-pane-container.active').toggleModalPane(false, true);
                // closeAllModalPanes();
                // if (e.state !== null && e.state !== '') {
                //     // $('#' + e.state).toggleModalPane(undefined, true);
                // }
            } else {
                var bits = url.split('#');
                $('.modal-pane-container.active').toggleModalPane(false, true);
                console.log(bits[1] === '');
                if (bits[1] === '') {
                    history.replaceState(null, null, "./");
                } else {
                    console.log(bits[1]);
                    if ($('#' + bits[1])[0]) {
                        $('#' + bits[1]).toggleModalPane(undefined, true);
                        history.replaceState(null, null, "./");
                    } else {
                        history.back()
                    }
                }
            }
        }


    });
}

function replaceThickBox(data) {
    var $tb_show = function $tb_show(a, b, c) {};
    if (typeof(window.tb_show) === 'function') {
        $tb_show = window.tb_show;
    }

    window.tb_show = function tb_show(a, b, c) {
        // var $tb_remove = function $tb_remove() {};
        if (!$('#TB_iframeContent_wrapper')[0]) {
            var frameHTML = '<div id="TB_iframeContent_wrapper"><iframe frameborder="0" hspace="0" id="TB_iframeContent" name="TB_iframeContent700" onload="backed = false; TB_iframeContent700.onpopstate = function(e) { if(backed == false){ e.stopPropagation(); e.preventDefault(); backed = true; window.history.back(); } };"></iframe></div>';
            $('#TB_iframeContent_wrapper').remove();
            $('body').append(frameHTML);
            $('#TB_iframeContent_wrapper').openInModalPane({
                openingButton: false,
                isFrame: true,
                paneTitleText: '',
                appendTo: data.appendTo,
                bodyClass: data.bodyClass,
                headerClass: data.headerClass,
                toolbarClass: data.toolbarClass,
                toolbarPaddingClass: data.toolbarPaddingClass,
                toggleHandler: data.toggleHandler
            });
        }
        var tb_frame = $('#TB_iframeContent');
        var tb_frame_wrapper = $('#TB_iframeContent_wrapper');

        //tb_frame.attr('src', b);
        TB_iframeContent700.location.replace(b);
        tb_frame.css({
            'width': '100vw',
            'height': 'calc(100vh - 40px)'
        });
        tb_frame_wrapper.toggleModalPane(true, false);
        toggleToolbar(window.event, true);
        // if (typeof(window.tb_remove) === 'function') {
        //     $tb_remove = window.tb_remove;
        // }
        window.tb_remove = function tb_remove(a, b, c) {
            history.back();
            // tb_frame_wrapper.toggleModalPane(true, false);
            // tb_frame_wrapper.closest('.modal-pane-wrapper').find('.close-button-box').click();
            // window.tb_remove = $tb_remove;
        };
    };
}

function appendScrollBodyEvents() {
    $('#sc_grid_body').off('scroll.syncFixedLabels');
    $('#summary_body > td').off('scroll.syncFixedLabels');
    $('#sc_grid_body').on('scroll.syncFixedLabels', scrollBody);
    $('#summary_body > td').on('scroll.syncFixedLabels', scrollBody);
}

function appendScrollButton() {
    var app = getAppData();
    var classPos = (app.scrollUpPosition == 'L') ? 'left' : 'right';
    var classHeight = ($('#sc_grid_toobar_bot')[0]) ? 'high' : 'low';
    switch (app.appType) {
        case 'form':
            headerClass = 'scFormHeader';
            headerFontClass = 'scFormHeaderFont';
            break;
    }
    var btn = '<div id="scrolltop-button" class="' + headerClass + ' ' + headerFontClass + ' ' + classPos + ' ' + classHeight + '"></div>';
    window.scrolltopTimer = null;
    $(window).off('scroll.scrlTopBtn');
    $(window).on('scroll.scrlTopBtn', checkScroll );
    $('td').off('scroll.scrlTopBtn');
    $('td').on('scroll.scrlTopBtn', function () { $(this).attr('data-scroll', $(this).scrollLeft()); checkScroll(); } );
    if (!$("#scrolltop-button")[0]) {
        $('body').append(btn);
        $('#scrolltop-button').each(function () {
            $(this).click(function () {
                //$('body,html').animate({scrollTop: 0, scrollLeft: 0}, 'fast');
                $('body,html').animate({scrollTop: 0}, 'fast');
                //$('[data-scroll]').animate({scrollTop: 0, scrollLeft: 0}, 'fast');
                $('[data-scroll]').animate({scrollTop: 0}, 'fast');
                return false;
            });
        });
    } else {
        $("#scrolltop-button").removeClass('active');
    }
}

function checkScroll() {
    if (typeof scSetFixedHeaders == 'function') { scSetFixedHeaders(); }
    var app = getAppData();
    if (!app.displayScrollUp) return false;
    var a = 10;
    var b = 10;
    // var pos = $('[data-scroll]').scrollTop();
    var pos = $(document).scrollTop();
    var posa = $(window).scrollLeft();
    var posb = $('[data-scroll]').not('[data-scroll="0"]').scrollLeft();
    switch (app.appType) {
        case 'grid':
            a = (parseInt($('#sc_grid_toobar_top').parent().outerHeight()) || 0);
            if ($('#TB_Interativ_Search')[0]) {
                pos = $('[data-scroll]').scrollTop();
            } else {
                pos = $(document).scrollTop();
            }
            break;
        case 'summary':
            a = (parseInt($('.scGridTabelaTd .scGridHeader').outerHeight()) || 0) + (parseInt($('#obj_barra_top').outerHeight()) || 0);
            pos = $(document).scrollTop();
            break;
        default:
            a = 50;
            break;
    }
    clearTimeout(scrolltopTimer);
    // if(pos > a ||posa > a || posb > b) {
    if(pos > a ) {
        if (!$("#scrolltop-button").hasClass('active')) {
            toggleScrollButton('show');
        }
        scrolltopTimer = setTimeout(function() { toggleScrollButton('hide'); }, 4000);
    } else {
        if ($("#scrolltop-button").hasClass('active')) {
            toggleScrollButton('hide');
        }
    }
}

function toggleScrollButton(state) {
    if(state === 'show') {
        $("#scrolltop-button").addClass('active');
        // $("#scrolltop-button").css({
        //     right: '20px'
        // });
    } else {
        $("#scrolltop-button").removeClass('active');
        // $("#scrolltop-button").css({
        //     right: ''
        // });
    }
}

function scBtnGrpShowMobile(sGroup) {
    var tgt = $('#sc_btgp_div_' + sGroup);
    if (!tgt) {
        tgt = $(sGroup);
    }
    var dT = tgt.prev()[0].getBoundingClientRect().top +  tgt.prev()[0].getBoundingClientRect().height - 5;
    tgt.stop().css('top', dT + 'px').stop().show('fade');
    var submenuOverlay = '<div class="submenuOverlay"></div>';

    tgt.parent().append(submenuOverlay);
    $('body, html').css({'overflow': 'hidden', 'height': '100vh'});
    // $('body, html').on("touchmove.lock", function (e) { e.preventDefault(); });
    $('#sc_btgp_div_' + sGroup + ' .thickbox').off('click.closeSubMenu');
    $('#sc_btgp_div_' + sGroup + ' .thickbox').on('click.closeSubMenu', function () {
        scBtnGrpHideMobile(sGroup);
        $('.submenuOverlay').off('click.closeSubMenu');
    });
    $('.submenuOverlay').on('click.closeSubMenu', function () {
        scBtnGrpHideMobile(sGroup);
        $('.submenuOverlay').off('click.closeSubMenu');
    });
}

function scBtnGrpHideMobile(sGroup) {
    if (sGroup === undefined) {
        $('.SC_SubMenuApp').stop().hide('fade', function () {
            $('.SC_SubMenuApp').css('margin-top', '0px');
            $('.submenuOverlay').remove();
        });
    } else {
        $('#sc_btgp_div_' + sGroup).stop().hide('fade', function () {
            $('#sc_btgp_div_' + sGroup).css('margin-top', '0px');
            $('.submenuOverlay').remove();
            if (!$('.overlayToolbar')[0]) {
                $('body, html').css({'overflow': '', 'height': ''});
                // $('body, html').off("touchmove.lock");
            }
        });
    }
}

function nm_show_dynamicsearch_fields_mobile() {
    var sGroup = 'table#id_dynamic_search_fields';
    var dT = 100 +  25;
    var submenuOverlay = '<div class="submenuOverlay"></div>';

    $(sGroup).css('top', dT + 'px').stop().show('fade');
    $(sGroup).parent().append(submenuOverlay);
    $('body, html').css({'overflow': 'hidden', 'height': '100vh'});
    $(sGroup + ' div').off('click.closeSubMenu');
    $(sGroup + ' div').on('click.closeSubMenu', function () {
        nm_hide_dynamicsearch_fields_mobile();
        $('.submenuOverlay').off('click.closeSubMenu');
    });
    $('.submenuOverlay').on('click.closeSubMenu', function () {
        nm_hide_dynamicsearch_fields_mobile();
        $('.submenuOverlay').off('click.closeSubMenu');
    });
    moveWithTouch(sGroup);
}
function nm_hide_dynamicsearch_fields_mobile() {
    var sGroup = 'table#id_dynamic_search_fields';
    if ($(sGroup)[0]) {
        $(sGroup).stop().hide('fade', function () {
            $(sGroup).css('margin-top', '0px');
            $('.submenuOverlay').remove();
        });
    }
}

function scIsHeaderVisibleMobile(gridHeaders) {
    var appData = getAppData();
    var app = appData.appType;
    var optbtn = appData.displayOptionsButton;
    var offset = gridHeaders.offset().top;
    var scToolbar = 'scGridToolbar';
    var hH = $('#sc_grid_head');
    var hM = 0;
    var pos = $(document).scrollTop();
    switch (app.appType) {
        case 'grid':
            if ($('#TB_Interativ_Search')[0]) {
                pos = $('[data-scroll]').scrollTop();
            } else {
                pos = $(document).scrollTop();
            }
            break;
        case 'summary':
            pos = $(document).scrollTop();
            break;
        default:
            break;
    }

    switch (app) {
        case 'grid':
            hH = $('#sc_grid_head');
            scToolbar = 'scGridToolbar';
            break;
        case 'summary':
            hH = $('.scGridTabelaTd .scGridHeader');
            scToolbar = 'scGridToolbar';
            break;
    }
    if (!optbtn) {
        hM = $($('.' + scToolbar)[0]).outerHeight();
    }
    return offset - hH.outerHeight() - hM > pos;
}

function nm_gp_open_qsearch_div_mobile (pos) {
    var popup = $('#id_qs_div_' + pos);
    if($('#SC_fast_search_dropdown_' + pos).hasClass('fa-caret-down'))
    {
        $('body').append(popup);
        popup.addClass('active');
        nm_gp_open_qsearch_div_store_temp(pos);
        $('#SC_fast_search_dropdown_' + pos).removeClass('fa-caret-down').addClass('fa-caret-up');
    }
    else
    {
        popup.removeClass('active');
        $('#SC_fast_search_dropdown_' + pos).removeClass('fa-caret-up').addClass('fa-caret-down');
    }
}

function sc_session_redir_mobile (url_redir) {
    var appData = getAppData();
    var app = appData.appType;
    switch (app) {
        case 'grid':
            var lft = $('#sc_grid_body').scrollLeft();
            $('#sc-id-fixedheaders-placeholder').css('left',  '-'+ lft +'px');
            break;
        case 'summary':
            var lft = $('#summary_body > td').scrollLeft();
            $('#sc-id-summary-fixedheaders-placeholder').css('left',  '-'+ lft +'px');
            break;
    }
    return lft;
}

function scrollBody() {
    var appData = getAppData();
    var app = appData.appType;
    switch (app) {
        case 'grid':
            var lft = $('#sc_grid_body').scrollLeft();
            $('#sc-id-fixedheaders-placeholder').css('left',  '-'+ lft +'px');
            // if ($('.scGridBlock')[0]) {
                // var padL = parseInt($($('.scGridBlock')[0]).css('padding-left')) || 0;
                // var padT = parseInt($($('.scGridBlock')[0]).css('padding-top')) || 0;
                // var h = parseInt($($('.scGridBlock')[0]).css('height')) || 0;
                // if (lft > padL) {
                //     $('.scGridBlock').css({
                //         'height': h + 'px'
                //     });
                //     $('.scGridBlock > table').css({
                //         //'left': '0px',
                //         'transform': 'translateY(-50%)',
                //         'display': 'block',
                //         'width': '100vw',
                //         'overflow': 'hidden',
                //         'text-overflow': 'ellipsis',
                //         'position': 'absolute'
                //     });
                // } else {
                //     $('.scGridBlock').css({
                //         'height': ''
                //     });
                //     $('.scGridBlock > table').css({
                //         'left': '',
                //         'top': '',
                //         'transform': '',
                //         'display': '',
                //         'width': '',
                //         'overflow': '',
                //         'position': 'static'
                //     });
                // }
            // }
            break;
        case 'summary':
            var lft = $('#summary_body > td').scrollLeft();
            $('#sc-id-summary-fixedheaders-placeholder').css('left',  '-'+ lft +'px');
            break;
    }
}

function toolbarPlacement() {
    var appData = getAppData();
    if (appData.displayOptionsButton) {
        var app = appData.appType;

        switch (app) {
            case 'grid':
                header = $('#sc_grid_head');
                scToolbar = 'scGridToolbar';
                headerClass = 'scGridHeader';
                headerFontClass = 'scGridHeaderFont';
                break;
            case 'search':
                header = $('.scFilterTableTd > .scFilterHeader:not(.modal-pane-container)').parent().parent();
                scToolbar = 'scFilterToolbar';
                headerClass = 'scFilterHeader';
                headerFontClass = 'scFilterHeaderFont';
                break;
            case 'form':
                header = $('.scFormHeader:not(.modal-pane-topbar, #scrolltop-button)').closest('td');
                scToolbar = 'scFormToolbar';
                headerClass = 'scFormHeader';
                headerFontClass = 'scFormHeaderFont';
                break;
            case 'detail':
            case 'summary':
                header = $('.scGridTabelaTd > .scGridHeader').parent().parent();
                scToolbar = 'scGridToolbar';
                headerClass = 'scGridHeader';
                headerFontClass = 'scGridHeaderFont';
                break;
        }
        if (['rgba(0, 0, 0, 0)', 'rgba(0,0,0,0)', 'transparent', ''].indexOf($($('.' + headerClass)[0]).css('background-color')) > -1)  {
            $('body').append('<style>.' + headerClass + ' { background-color: ' + $('body').css('background-color') + ' } </style>');
        }
        if (['rgba(0, 0, 0, 0)', 'rgba(0,0,0,0)', 'transparent', ''].indexOf($($('.' + scToolbar)[0]).css('background-color')) > -1)  {
            $('body').append('<style>.' + scToolbar + ' { background-color: ' + $('body').css('background-color') + ' } </style>');
        }
        if ($('.' + scToolbar)[0]) {
            var tB = $('.' + scToolbar)[0];
            //$(tB).find('> tbody > tr > td:last-child').remove();
        }

        var optionsButton = '<td style="display: flex; padding: 0; border: 0;"><div class="headerOptions ' + headerClass + '"><div class="optsDots ' + headerFontClass + '"></div></div></td>';

        $('.overlayToolbar').remove();
        $('body, html').css({'overflow': '', 'height': ''});
        // $('body, html').off("touchmove.lock");
        if (!$('.headerOptions')[0]) {
            header.find('td.scFilterTableTd').css({
                'display': 'flex',
                'width': 'calc(100vw - 3.5em)',
                'overflow': 'hidden'
            });
            header.append(optionsButton);
            optionsButton = header.find('.headerOptions');
            optionsButton.on('click.showToolbar', toggleToolbar);
        }
        header.addClass(headerClass);

    }
}

function applySiteScroll() {
    var appData = getAppData();
    var app = appData.appType;

    switch (app) {
        case 'grid':
            $('#sc_grid_toobar_top_table > tbody, #sc_grid_toobar_bot_table > tbody').attr('data-grab2scroll', 'true');
            break;
        case 'form':
            $('.scFormToolbar.sc-toolbar-top, .scFormToolbar.sc-toolbar-bottom').attr('data-grab2scroll', 'true');
            break;
        case 'search':
            $('.scFilterToolbar > tbody').attr('data-grab2scroll', 'true');
            break;
        case 'detail':
            $('.scGridToolbar > tbody').attr('data-grab2scroll', 'true');
            break;
        case 'chart':
        case 'summary':
            $('.scGridToolbar > tbody, #summary_body > .scGridTabelaTd').attr('data-grab2scroll', 'true');
            break;
    }

}

function toggleToolbar(e, forceClose) {
    scBtnGrpHideMobile();
    var appData = getAppData();
    if (!appData.displayOptionsButton) return false;
    var overlay = $('.overlayToolbar')[0] ? $('.overlayToolbar') : $('<div class="overlayToolbar"></div>');
    var app = appData.appType;
    var toolBarTop;
    var scToolbar;
    var scHeadOptions;
    var stState = (forceClose === undefined) ? false : forceClose;
    var body = $('body');

    switch (app) {
        case 'form':
            toolBarTop = $('.scFormToolbar.sc-toolbar-top').parent();
            scToolbar = $('.scFormToolbar.sc-toolbar-top');
            scHeadOptions = $('.scFormHeader:not(.modal-pane-topbar, #scrolltop-button)').closest('td').find('.headerOptions');
            break;
    }

    if (stState) {
        toolBarTop.stop().slideUp();
        overlay.stop().fadeOut(100, function () {
            $('body, html').css({'overflow': '', 'height': ''});
            // $('body, html').off("touchmove.lock");
            overlay.remove();
            scToolbar[0].scrollTo(0, 0);
        });
    } else {
        if (!$('.overlayToolbar')[0]) {
            toolBarTop.stop().slideDown();
            body.prepend(overlay);
            $('body, html').css({'overflow': 'hidden', 'height': '100vh'});
            // $('body, html').on("touchmove.lock", function (e) { e.preventDefault(); });
            overlay.stop().fadeIn();
            overlay.on('click.showToolbar', toggleToolbar);
            $('#slide_signal').stop().fadeIn(100);
            var t = setTimeout(function () {
                $('#slide_signal').stop().fadeOut(500);
            }, 4000);
            scToolbar.find('>tbody').on('scroll.removeTimeout', function () {
                clearTimeout(t);
                $('#slide_signal').stop().fadeOut(500);
                scHeadOptions.off('click.removeTimeout');
                $(this).off('scroll.removeTimeout');
            });
            scHeadOptions.on('click.removeTimeout', function () {
                clearTimeout(t);
                $('#slide_signal').stop().fadeOut(500);
                scToolbar.off('scroll.removeTimeout');
                $(this).off('click.removeTimeout');
            });
            overlay.on('click.removeTimeout', function () {
                clearTimeout(t);
                $('#slide_signal').stop().fadeOut(500);
                scToolbar.off('scroll.removeTimeout');
                scHeadOptions.off('click.removeTimeout');
                $(this).off('click.removeTimeout');
            });
        } else {
            toolBarTop.stop().slideUp();
            overlay.stop().fadeOut(100, function () {
                $('body, html').css({'overflow': '', 'height': ''});
                // $('body, html').off("touchmove.lock");
                overlay.remove();
                scToolbar[0].scrollTo(0, 0);
            });
        }
    }
}

function toolbarSpecificButtonBehaviour() {
    $('#limpa_frm_bot').on('click.toggleToolbar', function(e) { toggleToolbar(e,true); });
    // $('#Ativa_save_bot').on('click.toggleToolbar', function(e) { toggleToolbar(e,true); });
}

function toolbarStylingFixes() {
    var appData = getAppData();
    var app = appData.appType;

    switch (app) {
        case 'form':
            $('.scFormToolbarPadding').parent().css({
                'padding': 0
            });
            break;
    }
}

function specificStyle() {
    var appData = getAppData();
    var app = appData.appType;

    switch (app) {
        case 'form':
            var hH = $('.scFormHeader:not(.modal-pane-topbar, #scrolltop-button)').closest('td');
            var hT = $('.scFormToolbar.sc-toolbar-top');
            var bgColor = $('.scFormBorder').css('background-color');
            var simpleTB = appData.mobileSimpleToolbar;
            var fixedTB = appData.bottomToolbarFixed;
            var isMulti = (typeof $('#SC_tab_mult_reg')[0] !== typeof undefined);
            var isForm = ($('body').hasClass('sc-app-form'));
            var isCal = ($('body').hasClass('sc-app-calendar'));
            var isCtr = ($('body').hasClass('sc-app-contr') || $('body').hasClass('sc-app-contrusr'));
            $('.scGridToolbar, .scFilterToolbar , .scFormToolbar').attr('data-grab2scroll', 'true');



            hH.css({
                'display': 'flex',
                'flex-direction': 'row',
                'justify-content': 'space-between',
                'width': '100vw',
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'background-color': bgColor,
                'z-index': '10'
            });

            if (isMulti) {
                $('body').addClass('multi');
            }

            $('#main_table_form > table').parents('table, tbody, tr, td').attr('style', 'display: block !important; width: 100% !important;');
            $('.scFormToolbar.sc-toolbar-top').attr('style', 'display: block !important; width: 100% !important; position: relative;');
            $('#sc-id-fixedheaders-placeholder, #sc-id-fixedheaders-placeholder *').css('opacity',  'inherit');
            if (appData.displayOptionsButton) {
                $('#sc_grid_head > td.scGridTabelaTd').not('.headerOptions').attr('style', 'display: block !important; width: calc(100vw - 46px) !important;');
            } else {
                $('#sc_grid_head > td.scGridTabelaTd').not('.headerOptions').attr('style', 'display: block !important; width: calc(100vw) !important;');
            }
            $('.scFormTable').css({
                'padding': '0'
            });
            if (appData.scFormToolbarPadding) {
                $('.scFormToolbarPadding').parent().css({
                    'padding': 0
                });
            }
            $('.scFormTable').css({
                'padding': '0'
            });

            $('#SC_tab_mult_reg > table').css({
                'margin': '0'
            });

            if (appData.toolbarOrientation == 'V') {
                $('.scFormToolbar.sc-toolbar-top').css({
                    'display': 'flex',
                    'flex-direction': 'column',
                    'justify-content': 'center',
                    'justify-items': 'center',
                    'align-items': 'center',
                    'align-content': 'center',
                    'width': '100%',
                    'max-height': '200px',
                    'overflow-x': 'hidden',
                    'overflow-y': 'auto'
                });
                $('.scFormToolbar.sc-toolbar-top').find('.scFormToolbarPadding, tr, td, tbody').not('.SC_SubMenuApp *').attr('width', '');
                $('.scFormToolbar.sc-toolbar-top').find('.scFormToolbarPadding, tr, td, tbody').not('.SC_SubMenuApp *').css({
                    'display': 'flex',
                    'flex-direction': 'column',
                    'justify-content': 'center',
                    'justify-items': 'center',
                    'align-items': 'center',
                    'align-content': 'center',
                    'width': '100%'
                });
                $('.scFormToolbar.sc-toolbar-top').find('a, button, input, select, span').not('.SC_SubMenuApp *').css({
                    'justify-content': 'center',
                    'justify-items': 'center',
                    'align-items': 'center',
                    'align-content': 'center',
                    'text-align': 'center',
                    'margin': '2px 0',
                    'width': '100%'
                });
                if ($('#quicksearchph_top input[type="text"]').get()[0]) {
                    $('#quicksearchph_top input[type="text"]').get()[0].style.width = 'calc(100% - 35px)';
                }
                $(".NM_toolbar_sep").replaceWith('<hr style="width: 100%; border-color: rgba(0,0,0,.2); border-width: 0 0 1px 0;" />');
            } else {
                if (!$('#slide_signal')[0]) {
                    $('.scFormToolbar.sc-toolbar-top').append('<div id="slide_signal" style="position: fixed; height: ' + (parseInt(hT.outerHeight()) || 0) + 'px' + '; top: ' + (parseInt(hH.outerHeight()) || 0) + 'px' + ';"><div class="bnc_arrow">&#x2039;</div></div>');
                }

                $('.scFormToolbar.sc-toolbar-top').find('input[type="text"]').not('#quicksearchph_top input[type="text"]').css({
                    'padding': '5px',
                    'width': '35px'
                });

                $('body #quicksearchph_top img').css({
                    'top': '60%'
                });
            }
            if (appData.displayOptionsButton) {
                $('.scFormToolbar.sc-toolbar-top').parent().css({
                    'position': 'fixed',
                    'z-index': '10',
                    'top': (parseInt(hH.outerHeight()) || 0) + 'px',
                    'display' : 'none',
                    'width': '100%'
                });
                $('body').css({
                    'padding-top': (parseInt(hH.outerHeight()) || 0) + 'px',
                });
                $('#sc-id-fixedheaders-placeholder').css({
                    'margin-top': ((parseInt(hH.outerHeight()) || 0) - 1) + '.5px',
                    'z-index': '7'
                });

                mobileAddCSS('' +
                    '.sc-header-fixed { ' +
                        'top: ' + (parseInt(hH.outerHeight()) || 0) + 'px' + ' !important; ' +
                    '}'
                );
            } else {
                $('.scFormToolbar.sc-toolbar-top').parent().css({
                    'position': 'fixed',
                    'z-index': '10',
                    'top': (parseInt(hH.outerHeight()) || 0) + 'px',
                    'width': '100%'
                });
                var hT = $('.scFormToolbar.sc-toolbar-top').parent();
                $('body').css({
                    'padding-top': ((parseInt(hH.outerHeight()) || 0) + (parseInt(hT.outerHeight()) || 0)) + 'px',
                });
                $('#sc-id-fixedheaders-placeholder').css({
                    'margin-top': (((parseInt(hH.outerHeight()) || 0) + (parseInt(hT.outerHeight()) || 0)) - 1) + '.5px',
                    'z-index': '7'
                });

                mobileAddCSS('' +
                    '.sc-header-fixed { ' +
                        'top: ' + ((parseInt(hH.outerHeight()) || 0) + (parseInt(hT.outerHeight()) || 0)) + 'px' + ' !important; ' +
                    '}'
                );

                var t = setTimeout(function() { $('#slide_signal').stop().fadeOut(500); }, 4000);
            }
            if ($('.scFormToolbar.sc-toolbar-bottom')) {
                if (isForm && !isMulti && simpleTB) {
                    var height = '55px';
                    if (appData['navigationBarButtons'].includes('RC')) {
                         height = '75px';
                    }
                    $('body').css({
                        'padding-bottom': height
                    });
                    $('.scFormToolbar.sc-toolbar-bottom').css({
                        'position': 'fixed',
                        'left': '0',
                        'bottom': '0',
                        'overflow-x': 'hidden',
                        'height': height,
                        'width': '100vw',
                        'display': 'flex',
                        'flex-direction': 'column',
                        'align-items': 'center',
                        'justify-content': 'end'
                    });
                    $('.scFormToolbar.sc-toolbar-bottom').find('td.scFormToolbarPadding').css({
                        'padding': '0px',
                        'display': 'flex',
                        'flex-direction': 'row',
                        'align-items': 'center',
                        'justify-content': 'center',
                        'width': '100vw',
                        'margin-bottom': '10px'
                    });
                    $('.scFormToolbar.sc-toolbar-bottom').find('td.scFormToolbarPadding #sc_b_summary_b').css({
                        'position': 'absolute',
                        'top': '10px',
                        'pointer-events': 'none',
                        'padding': '0px'
                    });
                } else if (fixedTB) {
                    var height = $('.scFormToolbar.sc-toolbar-bottom').outerHeight();
                    $('body').css({
                        'padding-bottom': height
                    });
                    $('.scFormToolbar.sc-toolbar-bottom').css({
                        'position': 'fixed',
                        'z-index': '4',
                        'left': '0',
                        'bottom': '0',
                        'width': '100vw'
                    });
                } else {
                    $('.scFormToolbar.sc-toolbar-bottom').css({
                        'position': 'sticky',
                        'left': '0',
                        'width': '100vw'
                    });
                }
            } else {
                $('body').css({
                    'padding-bottom': ''
                });
            }
        break;
}
setTimeout(function(){
    checkScroll();
    scrollBody();
    $('body').addClass('ready');
}, 1000);
}

function mobileAddCSS(css) {
    var head = document.head || document.getElementsByTagName('head')[0];
    var style = document.createElement('style');

    head.appendChild(style);

    style.type = 'text/css';
    if (style.styleSheet){
        style.styleSheet.cssText = css;
    } else {
        style.appendChild(document.createTextNode(css));
    }
}
function getAppData() {
var app = {};
if ($('#sc-mobile-app-data')[0]) {
    app = JSON.parse($('#sc-mobile-app-data').val());
}
if (!app.langs) {
    app.langs = {};
}
return app;
}

function moveWithTouch(el, vertical, horizontal) {
$(el).on("touchstart.moveWithTouch", function(e) {
    var wH = window.innerHeight;
    var sP = $(this).outerHeight() + $(this)[0].getBoundingClientRect().y;
    var margin = parseInt($(this).css('margin-top'));
    var sY = e.changedTouches[0].pageY;

    $(this).on("touchmove.moveWithTouch", function (ee) {
        var mY = ee.changedTouches[0].pageY;
        var pY = mY - sY;
        var mR = (pY + margin);
        var fH;

        fH = (mR + $(this).outerHeight() + 130);
        if (fH <= wH) {
            margin = parseInt($(this).css('margin-top'));
            mR = mR - (fH - wH);
            sY = mY;
        }
        if (mR >= 0) {
            mR = 0;
            margin = 0;
            sY = mY;
        }
        ee.preventDefault();
        $(this).css('margin-top', mR + 'px');
    });

    $(this).on("touchend.moveWithTouch", function (ee) {
        $(this).off("touchcancel.moveWithTouch");
        $(this).off("touchmove.moveWithTouch");
        $(this).off("touchend.moveWithTouch");
    });

    $(this).on("touchcancel.moveWithTouch", function (ee) {
        $(this).off("touchcancel.moveWithTouch");
        $(this).off("touchmove.moveWithTouch");
        $(this).off("touchend.moveWithTouch");
    });
});
}



function checkScrollMobile() {
if (typeof scSetFixedHeaders == 'function') { scSetFixedHeaders(); }
var app = getAppData();
if (!app.displayScrollUp) return false;
var a = 10;
var b = 10;
// var pos = $('[data-scroll]').scrollTop();
var pos = $(document).scrollTop();
var posa = $(window).scrollLeft();
var posb = $('[data-scroll]').not('[data-scroll="0"]').scrollLeft();
switch (app.appType) {
    case 'grid':
        a = (parseInt($('#sc_grid_toobar_top').parent().outerHeight()) || 0);
        if ($('#TB_Interativ_Search')[0]) {
            pos = $('[data-scroll]').scrollTop();
        } else {
            pos = $(document).scrollTop();
        }
        break;
    case 'summary':
        a = (parseInt($('.scGridTabelaTd .scGridHeader').outerHeight()) || 0) + (parseInt($('#obj_barra_top').outerHeight()) || 0);
        pos = $(document).scrollTop();
        break;
    default:
        a = 50;
        break;
}
clearTimeout(scrolltopTimer);
// if(pos > a ||posa > a || posb > b) {
if(pos > a ) {
    if (!$("#scrolltop-button").hasClass('active')) {
        toggleScrollButton('show');
    }
    scrolltopTimer = setTimeout(function() { toggleScrollButton('hide'); }, 4000);
} else {
    if ($("#scrolltop-button").hasClass('active')) {
        toggleScrollButton('hide');
    }
}
}

function nm_topFrameRun(funcExecCall, args) {
    var pageRoot = window;

    while(pageRoot.parent !== pageRoot) {
        pageRoot = pageRoot.parent;
    } try {
        if (pageRoot && pageRoot.nmFrmScase && typeof (pageRoot.nmFrmScase[funcExecCall]) === 'function') {
            var a;
            if (!args) {
                a = [];
            } else {
                a = (typeof (args) === typeof ([]) && args.length !== undefined) ? args : [args];
            }
            // return pageRoot[funcExecCall].apply(window, a);
            window[funcExecCall] = pageRoot[funcExecCall];
            return window[funcExecCall].apply(window, a);
        } else {
            return false;
        }
    } catch(e) { }
}