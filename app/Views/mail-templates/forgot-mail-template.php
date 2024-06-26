<p>Dear <?= $mail_data['user']->name; ?> </p>
<p>
    Your password reset link for <?= $mail_data['user']->email; ?>
    <br>
    <?= $mail_data['actionLink']; ?>
    <a href="<?= $mail_data['actionLink']; ?>" target="_blank">Click Here</a> to reset your password.
    <br>
    This link will be deleted in 15 minutes, please ignore if you didn't make this request!
</p>