<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Interview Rescheduled - CRY</title>
</head>
<body style="background: #f9f9f9 url(stucco.png) repeat top left;">
    <div class="content">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="full" bgcolor="" c-style="bgImage" object="drag-module" style="margin-top:2%">
            <tr mc:repeatable>
                <td id="not1">
                    <div mc:hideable></div>
                </td>
            </tr>
        </table>
        
        <table width="392" border="0" cellpadding="0" cellspacing="0" align="center" class="full">
            <tr>
                <td align="center" width="20" valign="middle"></td>
                <td align="center" width="500" valign="middle">
                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="full">
                        <tr>
                            <td align="center" width="500" valign="middle" bgcolor="#ffc107" c-style="blueBG">
                                <div class="sortable_inner">
                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffc107">
                                        <tr>
                                            <td width="500" valign="middle" align="center">
                                                <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center;">
                                                    <tr>
                                                        <td align="center" valign="middle" width="100%" style="text-align: center; font-family: Helvetica, Arial, sans-serif; font-size: 25px; color: #ffffff; line-height: 30px;">
                                                            <span style="font-family: 'proxima_novathin', Helvetica;">Welcome to CRY</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="center" width="20" valign="middle"></td>
            </tr>
        </table>
        
        <table width="392" border="0" cellpadding="0" cellspacing="0" align="center" class="full">
            <tr>
                <td align="center" width="20" valign="middle"></td>
                <td align="center" width="500" valign="middle">
                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="full">
                        <tr>
                            <td align="center" width="500" valign="middle" bgcolor="#ffffff">
                                <div class="sortable_inner">
                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff">
                                        <tr>
                                            <td width="500" valign="middle" align="center">
                                                <table width="265" border="0" cellpadding="0" cellspacing="0" align="center">
                                                    <tr>
                                                        <td width="100%" height="40">
                                                            <span style="color:#999999;font-size:14px;"><?php echo date("F d, Y"); ?></span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff">
                                        <tr>
                                            <td width="500" valign="middle" align="left">
                                                <table width="450" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: left;">
                                                    <tr>
                                                        <td align="left" valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #212121;">
                                                            <span style="font-family: 'proxima_novathin', Helvetica;">
                                                                <singleline>Dear <?php echo $first_name ?? ''; ?> <?php echo $last_name ?? ''; ?>,</singleline>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <!-- OLD DETAILS SECTION -->
                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff">
                                        <tr>
                                            <td width="500" valign="middle" align="center">
                                                <table width="450" border="0" cellpadding="0" cellspacing="0" align="center">
                                                    <tr>
                                                        <td height="20"></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #d32f2f; line-height: 24px; background-color: #ffebee; padding: 15px; border-left: 4px solid #d32f2f;">
                                                            <span style="font-family: 'proxima_nova_rgregular', Helvetica;">
                                                                <strong style="font-size: 16px;">❌ Previous Interview Details (CANCELLED)</strong><br><br>
                                                                <strong>Format:</strong> <?php echo $old_mode ?? 'N/A'; ?><br>
                                                                <?php echo (($old_mode ?? '') == "Face to Face" ? "<strong>Venue:</strong> " . ($old_venue ?? 'N/A') . "<br>" : "") ?>
                                                                <strong>Date:</strong> <?php echo date("F d, Y", strtotime($old_schedule_date ?? date("Y-m-d"))); ?><br>
                                                                <strong>Time:</strong> <?php echo date("h:i A", strtotime($old_schedule_time ?? "00:00:00")); ?><br>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <!-- ARROW DIVIDER -->
                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td align="center" height="30">
                                                <span style="font-size: 24px;">⬇️</span>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <!-- NEW DETAILS SECTION -->
                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff">
                                        <tr>
                                            <td width="500" valign="middle" align="center">
                                                <table width="450" border="0" cellpadding="0" cellspacing="0" align="center">
                                                    <tr>
                                                        <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #2e7d32; line-height: 24px; background-color: #e8f5e9; padding: 15px; border-left: 4px solid #2e7d32;">
                                                            <span style="font-family: 'proxima_nova_rgregular', Helvetica;">
                                                                <strong style="font-size: 16px;">✅ Updated Interview Details</strong><br><br>
                                                                <strong>Format:</strong> <?php echo $new_mode ?? 'N/A'; ?><br>
                                                                <?php echo (($new_mode ?? '') == "Face to Face" ? "<strong>Venue:</strong> " . ($new_venue ?? 'N/A') . "<br>" : "") ?>
                                                                <strong>Date:</strong> <?php echo date("F d, Y", strtotime($new_schedule_date ?? date("Y-m-d"))); ?><br>
                                                                <strong>Time:</strong> <?php echo date("h:i A", strtotime($new_schedule_time ?? "00:00:00")); ?><br>
                                                                <?php if (!empty($hr_description)): ?>
                                                                <strong>Description:</strong> <?php echo $hr_description; ?><br>
                                                                <?php endif; ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff">
                                        <tr>
                                            <td width="500" valign="middle" align="center">
                                                <table width="450" border="0" cellpadding="0" cellspacing="0" align="center">
                                                    <tr>
                                                        <td height="20"></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #515151; line-height: 24px;">
                                                            <span style="font-family: 'proxima_nova_rgregular', Helvetica;">
                                                                We wish you the best of luck with your interview.<br>
                                                                If you have any queries, please reply to <?php echo $adminEmail ?? 'hr@cry.org'; ?>.
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="20"></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #515151; line-height: 24px;">
                                                            <span style="font-family: 'proxima_nova_rgregular', Helvetica;">
                                                                Warm regards,<br />
                                                                CRY Team
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="20"></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #999999;">
                                                            <span style="font-family: 'proxima_nova_rgregular', Helvetica;">
                                                                Note: This is a system generated mail. Please do NOT REPLY to this mail.
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="center" width="20" valign="middle"></td>
            </tr>
        </table>
    </div>
</body>
</html>