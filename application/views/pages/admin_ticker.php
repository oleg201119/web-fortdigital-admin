<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ADMIN SETTINGS
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-dashboard"></i>Home</li>
            <li class="active">Setting for Ticker</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- top row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Ticker Display of Incoming Messages Settings</h3>
                    </div>
<!--
                    <?php
                        echo form_open_multipart('admin/news_register');
                    ?>
-->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="font_14bold">
                                    Reset and Display From Beginning of Data <a href="javascript: void;" onclick="onreset_begin(); return false;" >Reset</a>
                                </h4>

                                <h4 class="font_14bold">
                                    Delete SQL DB and Empty all Data <a href="javascript: void;" onclick="onreset_queue(); return false;" >Reset</a>
                                </h4>

                                <h4 class="font_14bold">
                                    Pause/Freeze Current Display <a href="javascript: void;" onclick="onpause_rotating(); return false;" >Pause</a> , Resume Rotating <a href="javascript: void;" onclick="onresume_rotating(); return false;" >Resume</a>
                                </h4>

                                <br>

                                <div class="form-group">
                                    <label for="message_url">Pick Up Data From</label>
                                    <input type="text" class="form-control" id="message_url" name="message_url" placeholder="" value="<?php echo set_value('message_url', $ticker_config['pickup_url']); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="page_title">Page Title</label>
                                    <input type="text" class="form-control" id="page_title" name="page_title" placeholder="" value="<?php echo set_value('page_title', $ticker_config['page_title']); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="big_title">Big Title</label>
                                    <input type="text" class="form-control" id="big_title" name="big_title" placeholder="" value="<?php echo set_value('big_title', $ticker_config['big_title']); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="small_title">Small Title</label>
                                    <input type="text" class="form-control" id="small_title" name="small_title" placeholder="" value="<?php echo set_value('small_title', $ticker_config['small_title']); ?>">
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="demo_version" name="demo_version" <?php if ($ticker_config['demo_version'] == 1) echo "checked"; ?>/>
                                            <span class="font_14bold">Demo Version</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="show_footnote" name="show_footnote" <?php if ($ticker_config['show_footnote'] == 1) echo "checked"; ?>/>
                                            <span class="font_14bold">Shows Footnote</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="footnote_title">Footnote Title</label>
                                    <input type="text" class="form-control" id="footnote_title" name="footnote_title" placeholder="" value="<?php echo set_value('footnote_title', $ticker_config['footnote_title']); ?>">
                                </div>

                                <div class="form-group">
                                    <span class="font_14bold">
                                        Display New Message (Rotating ) Every &nbsp;&nbsp;
                                    </span>
                                    <input type="text" class="form-control" style="width: 60px; display: inline;" id="refresh_time" name="refresh_time" placeholder="" value="<?php echo set_value('refresh_time', $ticker_config['rotating_inteval']); ?>">
                                    <span class="font_14bold">
                                        &nbsp;&nbsp;Seconds
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="black_queue">If the message contain these words, Delete Them from Q</label>
                                    <textarea class="form-control" id="black_queue" name="black_queue" rows="5"><?php echo $ticker_config['blackword_list']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="auto_start" name="auto_start" <?php if ($ticker_config['auto_restart'] == 1) echo "checked"; ?>/>
                                            <span class="font_14bold">When reach end of data, auto start from beginning again?</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h4 class="font_14bold">
                                        Message Queue Status and Override:
                                    </h4>

                                    <table class="table table-bordered" id="message_queue_table">

                                        <tbody style="height: 200px; overflow-y: auto; overflow-x: hidden; display: block;">

                                            <tr>
                                                <th style="width: 10%">From</th>
                                                <th style="width: 50%">Message</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 10%">Freeze</th>
                                                <th style="width: 10%">Stop</th>
                                                <th style="width: 10%">Delete</th>
                                            </tr>


                                            <?php

                                            if (count($message_config['message_list']) == 0)
                                            {
                                            ?>
                                                <tr>
                                                    <td colspan="6" style="text-align: center; width: 1400px;">empty</td>
                                                </tr>
                                            <?php
                                            }

                                                foreach($message_config['message_list'] as $message_item)
                                                {
                                            ?>

                                                    <tr>
                                                        <td><?php echo $message_item['phone_number']; ?></td>
                                                        <td><?php echo $message_item['message_txt']; ?></td>
                                                        <td><?php if ($message_item['display'] == 1) echo "Displaying Now"; else echo "Queeing"; ?></td>
                                                        <td><a href="javascript: void;" onclick="<?php if ($message_item['display'] == 1) echo "onfreeze('" . $message_item['message_id'] . "');"; else echo "ondisplay_freeze('" . $message_item['message_id'] . "');"; ?>return false;"><?php if ($message_item['display'] == 1) echo "Freeze This One Now"; else echo "Display This One Now and Freeze"; ?></a></td>
                                                        <td><a href="javascript: void;" onclick="onstop_freeze('<?php echo $message_item['message_id']; ?>'); return false;">Stop Freeze</a></td>
                                                        <td><a href="javascript: void;" onclick="ondelete('<?php echo $message_item['message_id']; ?>'); return false;">Delete from Q</a></td>
                                                    </tr>

                                            <?php
                                                }

                                            ?>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="box-footer" style="text-align: center;">
                        <button style="width: 200px;" class="btn btn-primary" onclick="javascript: onsave(); return false;">&nbsp;Save&nbsp;</button>
                    </div>
<!--
                    <?php echo form_close(); ?> -->
            </div>
        </div>

    </section>
</aside>

<script language="javascript">

    function onreset_begin() {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/ticker_reset_begin') ?>",
            dataType: "json",
            type: "POST",
            data: {

            },
            success: function(json) {

                build_message_queue_table(json);

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function onreset_queue() {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/ticker_reset_queue') ?>",
            dataType: "json",
            type: "POST",
            data: {

            },
            success: function(json) {

                build_message_queue_table(json);

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function onpause_rotating() {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/ticker_pause_rotating') ?>",
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

    function onresume_rotating() {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/ticker_resume_rotating') ?>",
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

    function onfreeze(message_id)
    {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/ticker_freeze') ?>",
            dataType: "json",
            type: "POST",
            data: {
                message_id  : message_id
            },
            success: function(json) {

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function ondisplay_freeze(message_id)
    {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/ticker_display_freeze') ?>",
            dataType: "json",
            type: "POST",
            data: {
                message_id  : message_id
            },
            success: function(json) {

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function onstop_freeze(message_id)
    {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/ticker_stop_freeze') ?>",
            dataType: "json",
            type: "POST",
            data: {
                message_id  : message_id
            },
            success: function(json) {

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function ondelete(message_id)
    {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/ticker_delete_from_queue') ?>",
            dataType: "json",
            type: "POST",
            data: {
                message_id  : message_id
            },
            success: function(json) {

                build_message_queue_table(json);

                BootstrapDialog.alert('Operation Success !');
            },
            error: function(xhr, errStr) {
            //    alert(errStr);
            }
        });
    }

    function build_message_queue_table(message_list)
    {
        $('#message_queue_table').html = '';

        var html = '';

        html += '<tr>';
        html += '<th style="width: 10%">From</th>';
        html += '<th style="width: 50%">Message</th>';
        html += '<th style="width: 10%">Status</th>';
        html += '<th style="width: 10%">Freeze</th>';
        html += '<th style="width: 10%">Stop</th>';
        html += '<th style="width: 10%">Delete</th>';
        html += '</tr>';


        for(id in message_list)
        {
            html += '<tr>';
            html += '    <td>' + message_list[id]['phone_number'] + '</td>';
            html +=     '<td>' + message_list[id]['message_txt'] + '</td>';

            if (message_list[id]['display'] == 1)
                html +=     '<td>' + 'Displaying Now' + '</td>';
            else
                html +=     '<td>' + 'Queeing' + '</td>';

            if (message_list[id]['display'] == 1)
            {
                html +=     '<td><a href="javascript: void;" onclick="onfreeze(\'' + message_list[id]['message_id'] + '\'); return false;">';
                html +=     'Freeze This One Now';
                html +=     '</a></td>';
            }
            else
            {
                html +=     '<td><a href="javascript: void;" onclick="ondisplay_freeze(\'' + message_list[id]['message_id'] + '\'); return false;">';
                html +=     'Display This One Now and Freeze';
                html +=     '</a></td>';
            }

            html +=     '<td><a href="javascript: void;" onclick="onstop_freeze(\'' + message_list[id]['message_id'] + '\'); return false;">Stop Freeze</a></td>';
            html +=     '<td><a href="javascript: void;" onclick="ondelete(\'' + message_list[id]['message_id'] + '\'); return false;">Delete from Q</a></td>';
            html += '</tr>';
        }

        if (message_list.length == 0)
        {
            html += '<tr>';
            html += '<td colspan="6" style="text-align: center; width: 1400px;">empty</td>';
            html += '</tr>';
        }

        $('#message_queue_table tbody').html(html);
    }

    function onsave() {

        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/set_ticker_config') ?>",
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
                refresh_time    : $('#refresh_time').val(),
                black_queue     : $('#black_queue').val(),
                auto_start      : $('#auto_start').is(':checked') ? 1 : 0
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