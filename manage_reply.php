<?php include 'db_connect.php' ?>
<?php
if (isset($_GET['id'])) {
    $stmtReply = $conn->prepare("SELECT * FROM replies WHERE id = :id");
    $stmtReply->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmtReply->execute();

    $resultReply = $stmtReply->fetch(PDO::FETCH_ASSOC);

    foreach ($resultReply as $k => $v) {
        $$k = $v;
    }
}
?>

<div class="container-fluid">
	<form action="" id="update-reply">
				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id']:'' ?>" class="form-control">
		
		<div class="row form-group">
			<div class="col-md-12">
				<label class="control-label">reply</label>
				<textarea name="reply" class="text-jqte"><?php echo isset($reply) ? $reply : '' ?></textarea>
			</div>
		</div>
	</form>
</div>

<script>
	$('.select2').select2({
		placeholder:"Please select here",
		width:"100%"
	})
	$('.text-jqte').jqte();
	$('#update-reply').submit(function(e){
		$.ajax({
			url:'ajax.php?action=save_reply',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Data successfully saved.",'success')
				}
			}
		})
	})
</script>