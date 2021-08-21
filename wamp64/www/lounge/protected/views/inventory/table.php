
			$check_table=Salesx::model()->find('table_number=:t and staff!=:s and closed=:kk and substr(created_at,1,10)=:b',array(':t'=>$table,':s'=>Yii::app()->user->id, ':kk'=>0,':b'=>date('Y-m-d')));

			if($check_table!=null)
			{
				?>
				<script type="text/javascript">
				alert('Table already assigned to another waiter'); return;
								</script>

				<?php
				$fin=2;
				die;
			}