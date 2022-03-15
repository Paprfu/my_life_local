<?php

function showAddCalendarEventModal() {
    ?>
    <div id="add-calendar-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalAddCalendarEvent"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalAddCalendarEvent">Pridanie udalosti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="form-group row">
                                <label for="name-input" class="control-label">Názov</label>

                                <input id="name-input" type="text" class="form-control" name="name"
                                       placeholder="Názov">

                            </div>
                            <div class="form-group row">
                                <label class="control-label" for="start-date-input">Dátum</label>

                                <input id="start-date-input" type="date" class="form-control"
                                       name="date" value="<?php try {
                                    $date = new DateTime(Globals::$today);
                                } catch (Exception $e) {
                                }
                                echo $date->format('Y-m-d') ?>">
                                <label for="start-time-input"></label>
                                <input id="start-time-input" type="time" class="form-control"
                                       name="time" value="<?php try {
                                    $date = new DateTime(Globals::$today);
                                } catch (Exception $e) {
                                }
                                echo $date->format('h:i') ?>">
                            </div>
                            <div class="form-group row">
                                <label class="control-label" for="end-date-input">Dátum</label>

                                <input id="end-date-input" type="date" class="form-control"
                                       name="date" value="<?php try {
                                    $date = new DateTime(Globals::$today);
                                } catch (Exception $e) {
                                }
                                echo $date->format('Y-m-d') ?>">
                                <label for="end-time-input"></label>
                                <input id="end-time-input" type="time" class="form-control"
                                       name="time" value="<?php try {
                                    $date = new DateTime(Globals::$today);
                                } catch (Exception $e) {
                                }
                                echo $date->format('h:i') ?>">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-dark">
                    <button id="confirm-button" type="button" class="btn btn-common waves-effect"
                            onclick="createCalendarEvent(<?php echo Globals::$person->id ?>)">Pridať
                    </button>
                    <button type="button" class="btn btn-secondary waves-effect"
                            data-dismiss="modal">Zavrieť
                    </button>
                    <div id="add-calendar-event-msg">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
