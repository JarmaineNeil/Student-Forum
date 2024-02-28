<?php include 'db_connect.php' ?>
<?php
if (isset($_GET['id'])) {
    $stmtTopic = $conn->prepare("SELECT * FROM topics WHERE id = :id");
    $stmtTopic->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmtTopic->execute();

    $resultTopic = $stmtTopic->fetch(PDO::FETCH_ASSOC);

    foreach ($resultTopic as $k => $v) {
        $$k = $v;
    }
}
?>

<div class="container-fluid">
	<form action="" id="manage-topic">
				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id']:'' ?>" class="form-control">
		<div class="row form-group">
			<div class="col-md-8">
				<label class="control-label">Title</label>
				<input type="text" name="title" class="form-control" value="<?php echo isset($title) ? $title:'' ?>">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-8">
				<label class="control-label">Category</label>
				<select name="category_ids[]" id="category_ids" multiple="multiple" class="custom-select select2">
					<option value=""></option>
					<?php
					$tagStmt = $conn->query("SELECT * FROM categories ORDER BY name ASC");
					while ($row = $tagStmt->fetch(PDO::FETCH_ASSOC)):
					?>

					<option value="<?php echo $row['id'] ?>" <?php echo isset($category_ids) && in_array($row['id'], explode(",",$category_ids)) ? "selected" : '' ?>><?php echo $row['name'] ?></option>
			<?php endwhile; ?>
			</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<label class="control-label">Content</label>
				<textarea name="content" class="text-jqte"><?php echo isset($content) ? $content : '' ?></textarea>
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
	$('#manage-topic').submit(function(e){
		$.ajax({
			url:'ajax.php?action=save_topic',
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