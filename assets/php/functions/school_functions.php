<?php


function showSchool(?School $school, bool $edit, int $number) {

        if($school == null) {
            return;
        }

        if (!$edit)
            echo " <tr id='project-tr-$school->id'>";
        ?>
        <td><?php echo $number; ?></td>
        <td><a class="btn-link"
               href="?page=project&project=<?php echo $school->id ?>"><?php echo $school->name ?></a>
        </td>
        <td><?php echo dateToWrite($school->start) ?></td>
        <td><?php $echo = $school->end == null ? $school->end : dateToWrite($school->end);
            echo $echo ?></td>
        <?php

        if ($school->done == 1) {
            ?>
            <td><a href="#" class="badge badge-success">Successful</a></td>
            <?php
        } else if ($school->done == 0 && ($school->end <= new DateTime('now'))) {
            ?>
            <td><a href="#" class="badge badge-info">In progress</a></td>
            <?php
        } else if ($school->end != '-' && $school->start <= $school->end && $school->done == 0) {
            ?>
            <td><a href="#" class="badge badge-danger">Canceled</a></td>
            <?php
        }
        ?>
        <td>
            <div class="btn-group dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
                   data-toggle="dropdown" aria-expanded="false"><i
                        class="lni-more-alt"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <?php
                    if ($school->done == 1) {
                        ?>
                        <a class="dropdown-item" onclick="endSchool(<?php echo $school->id ?>)"><i
                                class="lni-close mr-2 text-gray"></i>Cancel ending</a>
                    <?php } else if ($school->done == 0) { ?>
                        <a class="dropdown-item" onclick="startSchool(<?php echo $school->id ?>)"><i
                                class="lni-check-box mr-2 text-gray"></i>End</a>
                    <?php } ?>
                    <a class="dropdown-item" onclick="editSchool(<?php echo $school->id ?>, <?php echo 1 ?>)"><i
                            class="lni-pencil mr-2 text-gray"></i>Edit</a>
                    <a class="dropdown-item" onclick="deleteSchool(<?php echo $school->id ?>)"><i
                            class="lni-trash mr-2 text-gray"></i>Delete</a>

                </div>
            </div>
        </td>
        <?php
        if (!$edit) {
            echo "</tr>";
        }
}