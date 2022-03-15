<?php


function showTeamInTable(Team $team, int $number)
{
    ?>
    <tr id="teams-tr-<?php echo $team->id ?>">
        <td><?php echo $number ?></td>
        <td> <?php echo $team->name ?></td>
        <td> <?php echo $team->getNumberOfGoals() . ':' . $team->getNumberOfConcededGoals() ?></td>
        <td><?php echo $team->getNumberOfWins() ?></td>
        <td><?php echo $team->getNumberOfDraws() ?></td>
        <td><?php echo $team->getNumberOfLosses() ?></td>
        <td><?php echo $team->getNumberOfPoints() ?></td>
        <td>
            <div class="btn-group dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
                   data-toggle="dropdown" aria-expanded="false"><i
                            class="lni-more-alt"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item"
                       onclick="deleteTeam(<?php echo $team->id ?>)"><i
                                class="lni-trash mr-2 text-gray"></i>Vymazať</a>

                </div>
            </div>
        </td>
    </tr>

    <?php


}