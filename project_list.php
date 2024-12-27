<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<?php if($_SESSION['login_type'] != 3): ?>
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_project"><i class="fa fa-plus"></i> Add New Project</a>
			</div>
			<?php endif; ?>
		</div>
		<div class="card-body">
			<table class="table table-hover table-striped table-condensed" id="project-list">
				<colgroup>
					<col width="5%">
					<col width="35%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Project</th>
						<th>Date Started</th>
						<th>Due Date</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$stat = array("Pending","Started","On-Progress","On-Hold","Over Due","Done");
					$where = "";
					if($_SESSION['login_type'] == 2){
						$where = " WHERE manager_id = '{$_SESSION['login_id']}' ";
					}elseif($_SESSION['login_type'] == 3){
						$where = " WHERE concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
					}
					$qry = $conn->query("SELECT * FROM project_list $where ORDER BY name ASC");
					while($row = $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2>"]);
						$desc = strtr(html_entity_decode($row['description']), $trans);
						$desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);

						$tprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['id']}")->num_rows;
						$cprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['id']} AND status = 3")->num_rows;
						$prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
						$prog = $prog > 0 ? number_format($prog, 2) : $prog;

						$prod = $conn->query("SELECT * FROM user_productivity WHERE project_id = {$row['id']}")->num_rows;

						if ($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
							if ($prod > 0 || $cprog > 0) {
								$row['status'] = 2;
							} else {
								$row['status'] = 1;
							}
						elseif ($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
							$row['status'] = 4;
						endif;
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td>
							<p><b><?php echo ucwords($row['name']) ?></b></p>
							<p class="truncate"><?php echo strip_tags($desc) ?></p>
						</td>
						<td><b><?php echo date("M d, Y", strtotime($row['start_date'])) ?></b></td>
						<td><b><?php echo date("M d, Y", strtotime($row['end_date'])) ?></b></td>
						<td class="text-center">
							<?php
								$status = $stat[$row['status']];
								$badgeClass = '';

								switch ($status) {
									case 'Pending': $badgeClass = 'badge-secondary'; break;
									case 'Started': $badgeClass = 'badge-primary'; break;
									case 'On-Progress': $badgeClass = 'badge-info'; break;
									case 'On-Hold': $badgeClass = 'badge-warning'; break;
									case 'Over Due': $badgeClass = 'badge-danger'; break;
									case 'Done': $badgeClass = 'badge-success'; break;
								}

								echo "<span class='badge {$badgeClass}'>{$status}</span>";
							?>
						</td>
						<td class="text-center">
							<div class="btn-group">
								<button type="button" class="btn btn-info btn-sm view_project" data-id="<?php echo $row['id'] ?>" title="View Project">
									<i class="fa fa-eye"></i>
								</button>
								<?php if($_SESSION['login_type'] != 3): ?>
								<button type="button" class="btn btn-primary btn-sm edit_project" data-id="<?php echo $row['id'] ?>" title="Edit Project">
									<i class="fa fa-edit"></i>
								</button>
								<button type="button" class="btn btn-danger btn-sm delete_project" data-id="<?php echo $row['id'] ?>" title="Delete Project">
									<i class="fa fa-trash"></i>
								</button>
								<?php endif; ?>
							</div>
						</td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<style>
	
	table p.truncate {
		margin: unset;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	table td {
		vertical-align: middle !important;
	}
</style>

<script>
	$(document).ready(function() {
		$('#project-list').DataTable({
			"order": [[ 1, "asc" ]],
			"language": {
				"search": "Filter projects:",
				"lengthMenu": "Show _MENU_ entries"
			},
		});

		$('.view_project').click(function() {
			location.href = './index.php?page=view_project&id=' + $(this).attr('data-id');
		});
		
		$('.edit_project').click(function() {
			location.href = './index.php?page=edit_project&id=' + $(this).attr('data-id');
		});

		$('.delete_project').click(function() {
			_conf("Are you sure to delete this project?", "delete_project", [$(this).attr('data-id')]);
		});
	});

	function delete_project(id) {
		start_load();
		$.ajax({
			url: 'ajax.php?action=delete_project',
			method: 'POST',
			data: { id: id },
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success');
					setTimeout(function() {
						location.reload();
					}, 1500);
				}
			},
			error: function() {
				alert_toast("An error occurred while deleting the project", 'danger');
				end_load();
			}
		});
	}
</script>
