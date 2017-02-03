<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ADMIN SETTINGS
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-dashboard"></i>Home</li>
            <li class="active">Setting for Voting</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- top row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Voting Displays Settings</h3>
                    </div>

                    <?php
                    echo form_open_multipart('admin/news_register');
                    ?>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="font_14bold">
                                    Reset Poll to Zero <a href="javascript: void;" onclick="onreset_begin(); return false;" >Reset (After reset, system will read entire data)</a>
                                </h4>

                                <h4 class="font_14bold">
                                    Reset Poll to Zero <a href="javascript: void;" onclick="onreset_now(); return false;" >Reset (After reset, system only read data start from reset time, not entire data)</a>
                                </h4>


                                <h4 class="font_14bold">
                                    Pause/Freeze Current Display <a href="javascript: void;" onclick="onpause_calc(); return false;" >Pause</a> , Resume Calculating Votes <a href="javascript: void;" onclick="onresume_calc(); return false;" >Resume</a>
                                </h4>

                                <br>

                                <div class="form-group">
                                    <label for="message_url">Pick Up Data From</label>
                                    <input type="text" class="form-control" id="message_url" name="message_url" placeholder="" value="<?php echo set_value('message_url', $voting_config['pickup_url']); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="page_title">Page Title</label>
                                    <input type="text" class="form-control" id="page_title" name="page_title" placeholder="" value="<?php echo set_value('page_title', $voting_config['page_title']); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="big_title">Big Title</label>
                                    <input type="text" class="form-control" id="big_title" name="big_title" placeholder="" value="<?php echo set_value('big_title', $voting_config['big_title']); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="small_title">Small Title</label>
                                    <input type="text" class="form-control" id="small_title" name="small_title" placeholder="" value="<?php echo set_value('small_title', $voting_config['small_title']); ?>">
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="demo_version" name="demo_version" <?php if ($voting_config['demo_version'] == 1) echo "checked"; ?>/>
                                            <span class="font_14bold">Demo Version</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="show_footnote" name="show_footnote" <?php if ($voting_config['show_footnote'] == 1) echo "checked"; ?>/>
                                            <span class="font_14bold">Shows Footnote</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="footnote_title">Footnote Title</label>
                                    <input type="text" class="form-control" id="footnote_title" name="footnote_title" placeholder="" value="<?php echo set_value('footnote_title', $voting_config['footnote_title']); ?>">
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="allow_duplicate" name="allow_duplicate" <?php if ($voting_config['duplicated_entry'] == 0) echo "checked"; ?>/>
                                            <span class="font_14bold">Does Not Allow Duplicates Entry</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h4 class="font_14bold">
                                        If comes from same number, only take 1 vote (the oldest message received)
                                        <br>
                                        If untick, duplicates entries from same number will be taken.
                                    </h4>
                                </div>

                                <br>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="allow_wrong_entry" name="allow_wrong_entry" <?php if ($voting_config['allow_wrong_entry'] == 1) echo "checked"; ?>/>
                                            <span class="font_14bold">Allow Wrong Entry</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h4 class="font_14bold">
                                        As far as the message contain the choice, it will be taken as valid votes although the message contain
                                        other things like signature or other text.
                                        <br>
                                        If untick, the message must be strictly contain the choice only to be regarded as valid vote.
                                    </h4>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="show_valid_votes" name="show_valid_votes" <?php if ($voting_config['show_valid_votes'] == 1) echo "checked"; ?>/>
                                            <span class="font_14bold">Shows Total Valid Votes</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="show_invalid_votes" name="show_invalid_votes" <?php if ($voting_config['show_invalid_votes'] == 1) echo "checked"; ?>/>
                                            <span class="font_14bold">Shows Total Invalid Votes</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="show_number_votes" name="show_number_votes" <?php if ($voting_config['show_number_votes'] == 1) echo "checked"; ?>/>
                                            <span class="font_14bold">Shows Total number of Votes</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h4 class="font_14bold">
                                        Contestant Label and Code Code:
                                    </h4>

                                    <table class="table table-bordered" id="contestant_table">

                                        <tbody style="width: 100%; height: 200px; overflow-y: auto; overflow-x: hidden;">

                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width: 40%">Contestant Label</th>
                                            <th style="width: 30%">SMS Code</th>
                                            <th style="width: 30%">Action</th>
                                        </tr>

                                        <?php

                                        if (count($voting_config['contestant_list']) == 0)
                                        {
                                            ?>
                                            <tr>
                                                <td colspan="3" style="text-align: center; width: 1400px;">empty</td>
                                            </tr>
                                        <?php
                                        }

                                        foreach($voting_config['contestant_list'] as $contestant_item)
                                        {
                                            ?>

                                            <tr>
                                                <td style="display: none;"><?php echo $contestant_item['contestant_id']; ?></td>
                                                <td><?php echo $contestant_item['contestant_label']; ?></td>
                                                <td><?php echo $contestant_item['sms_code']; ?></td>
                                                <td><a href="javascript: ondelete_contestant('<?php echo $contestant_item['contestant_id']; ?>');">Delete</a> | <a href="javascript: onedit_contestant('<?php echo $contestant_item['contestant_id']; ?>','<?php echo $contestant_item['contestant_label']; ?>','<?php echo $contestant_item['sms_code']; ?>');">Edit</a></td>
                                            </tr>

                                        <?php
                                        }

                                        ?>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group">
                                    <h4 class="font_14bold">
                                        Add new contestant and sms code
                                    </h4>
                                </div>

                                <div class="form-group">
                                    <span class="font_14bold">
                                        Contestant &nbsp;&nbsp;
                                    </span>
                                    <input type="text" class="form-control" style="width: 150px; display: inline;" id="contestant_name" name="contestant_name" placeholder="" value="">
                                    <span class="font_14bold">
                                        &nbsp;&nbsp;
                                    </span>

                                    <span class="font_14bold">
                                        SMS Code &nbsp;&nbsp;
                                    </span>
                                    <input type="text" class="form-control" style="width: 150px; display: inline;" id="sms_code" name="sms_code" placeholder="" value="">
                                    <span class="font_14bold">
                                        &nbsp;&nbsp;
                                    </span>

                                    <button class="btn btn-success" onclick="javascript: onadd_contestant(); return false;">&nbsp;Add&nbsp;</button>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="box-footer" style="text-align: center;">
                        <button style="width: 200px;" class="btn btn-primary" onclick="javascript: onsave(); return false;">&nbsp;Save&nbsp;</button>
                    </div>

                    <style>
                        .ui-dialog-titlebar-close {
                            display: none;
                        }
                    </style>
                    <div id="edit_dialog" title="Edit contestant" style="display: none; font-size: 12px;">
                        <p>
                        <table border="0" cellpading="0" cellspacing="0">
                            <tr>
                                <td>
                                    Contestant:
                                </td>
                                <td>
                                    <input type="text" class="form-control" style="width: 150px; display: inline;" id="contestant_edit_name" name="contestant_edit_name" placeholder="" value="">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    SMS Code:
                                </td>
                                <td>
                                    <input type="text" class="form-control" style="width: 150px; display: inline;" id="sms_edit_code" name="sms_edit_code" placeholder="" value="">
                                </td>
                            </tr>
                        </table>
                        </p>

                        <p style="text-align: center">
                            <button style="width: 100px;" class="btn btn-primary" onclick="javascript: ondlgsave(); return false;">&nbsp;Ok&nbsp;</button>
                            <button style="width: 100px;" class="btn btn-primary" onclick="javascript: $('#edit_dialog').dialog('close'); return false;">&nbsp;Cancel&nbsp;</button>
                        </p>

                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>

    </section>
</aside>

<script language="javascript">

    function build_contestant_table(contestant_list)
    {
        $('#contestant_table').html = '';

        var html = '';

        html += '<tr>';
        html += '<th style="display: none;"></th>';
        html += '<th style="width: 40%">Contestant Label</th>';
        html += '<th style="width: 30%">SMS Code</th>';
        html += '<th style="width: 30%">Action</th>';
        html += '</tr>';

        for(id in contestant_list)
        {
            html += '<tr>';
            html += '    <td style="display: none;">' + contestant_list[id]['contestant_id'] + '</td>';
            html += '    <td>' + contestant_list[id]['contestant_label'] + '</td>';
            html += '    <td>' + contestant_list[id]['sms_code'] + '</td>';
            html += '    <td>' + '<a href="javascript: ondelete_contestant(\'' + contestant_list[id]['contestant_id'] + '\');">Delete</a>' + ' | ' + '<a href="javascript: onedit_contestant(\'' + contestant_list[id]['contestant_id'] + '\',\''+contestant_list[id]['contestant_label']+'\',\''+contestant_list[id]['sms_code']+'\');">Edit</a>' + '</td>';

            html += '</tr>';
        }

        if (contestant_list.length == 0)
        {
            html += '<tr>';
            html += '<td colspan="3" style="text-align: center; width: 1400px;">empty</td>';
            html += '</tr>';
        }

        $('#contestant_table tbody').html(html);
    }

    function onreset_begin() {
        $.ajax({
            async: false,
            url: "<?php echo site_url('admin/voting_reset_begin') ?>",
            dataType: "json",
            type: "POST",
            data: {

            },
            success: function(json) {

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function onreset_now() {
        $.ajax({
            async: false,
            url: "<?php echo site_url('admin/voting_reset_now') ?>",
            dataType: "json",
            type: "POST",
            data: {

            },
            success: function(json) {

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function onpause_calc()
    {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/voting_pause_calc') ?>",
            dataType: "json",
            type: "POST",
            data: {

            },
            success: function(json) {

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function onresume_calc()
    {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/voting_resume_calc') ?>",
            dataType: "json",
            type: "POST",
            data: {

            },
            success: function(json) {

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function onadd_contestant()
    {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/voting_add_contestant') ?>",
            dataType: "json",
            type: "POST",
            data: {
                contestant: $('#contestant_name').val(),
                sms_code:   $('#sms_code').val()
            },
            success: function(json) {

                build_contestant_table(json);

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function ondelete_contestant(id)
    {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/voting_delete_contestant') ?>",
            dataType: "json",
            type: "POST",
            data: {
                id: id
            },
            success: function(json) {

                build_contestant_table(json);

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function onedit_contestant(id, label, code)
    {
        $("#edit_dialog").data('id', id);
        $("#edit_dialog").data('label', label);
        $("#edit_dialog").data('code', code);

        $('#contestant_edit_name').val(label);
        $('#sms_edit_code').val(code);

        $("#edit_dialog").dialog({width:300,
            height: 200,
            modal: true
        });
    }

    function ondlgsave()
    {
        var id = $("#edit_dialog").data('id');
        var label = $('#contestant_edit_name').val();
        var code = $('#sms_edit_code').val();

        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/voting_update_contestant') ?>",
            dataType: "json",
            type: "POST",
            data: {
                id: id,
                label: label,
                code: code
            },
            success: function(json) {

                build_contestant_table(json);

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });

        $("#edit_dialog").dialog('close');
    }

    function onsave() {

        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/set_voting_config') ?>",
            dataType: "json",
            type: "POST",
            data: {
                message_url     : $('#message_url').val(),
                page_title      : $('#page_title').val(),
                big_title       : $('#big_title').val(),
                small_title     : $('#small_title').val(),
                demo_version    : $('#demo_version').is(':checked') ? 1 : 0,
                show_footnote   : $('#show_footnote').is(':checked') ? 1 : 0,
                footnote_title  : $('#footnote_title').val(),

                allow_duplicate : $('#allow_duplicate').is(':checked') ? 0 : 1,
                allow_wrong_entry: $('#allow_wrong_entry').is(':checked') ? 1 : 0,
                show_valid_votes: $('#show_valid_votes').is(':checked') ? 1 : 0,
                show_invalid_votes: $('#show_invalid_votes').is(':checked') ? 1 : 0,
                show_number_votes: $('#show_number_votes').is(':checked') ? 1 : 0
            },
            success: function(json) {

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

</script>