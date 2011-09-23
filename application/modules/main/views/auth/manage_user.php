<div class='mainInfo'>

    <h2>Users</h2>
    <p>Below is a list of the users.</p>

    <div id="infoMessage"><?php echo $message;?></div>

    <table cellpadding=0 cellspacing=10>
        <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Groups</th>
                <th>Status</th>
                <th>Action</th>
        </tr>
        <?php foreach ($users as $user):?>
            <tr>
                <td><?php echo $user->first_name;?></td>
                <td><?php echo $user->last_name;?></td>
                <td><?php echo $user->email;?></td>
                <td>
                    <?php foreach ($user->groups as $group):?>
                        <?php echo $group->name;?><br />
                    <?php endforeach?>
                </td>
                <td><?php echo ($user->active) ? 'Active' : 'Inactive';?></td>
                <td>
                    <?php echo ($user->active) ? 
                        anchor("main/deactivate/".$user->id, 'Deactivate') : 
                        anchor("main/activate/". $user->id, 'Activate');
                    ?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
	
</div>
