<?php include 'db_connect.php' ?>
<?php
if (isset($_GET['id'])) {
    $stmtComment = $conn->prepare("SELECT * FROM comments WHERE id = :id");
    $stmtComment->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmtComment->execute();

    $resultComment = $stmtComment->fetch(PDO::FETCH_ASSOC);

    foreach ($resultComment as $k => $v) {
        $$k = $v;
    }
}
?>

<div class="container-fluid">
	<form action="" id="update-comment">
				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id']:'' ?>" class="form-control">
		
		<div class="row form-group">
			<div class="col-md-12">
				<label class="control-label">Comment</label>
				<textarea name="comment" class="text-jqte"><?php echo isset($comment) ? $comment : '' ?></textarea>
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
	$('#update-comment').submit(function(e){
		$.ajax({
			url:'ajax.php?action=save_comment',
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