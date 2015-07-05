<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 19.02.2015
 * Time: 22:31
 */

namespace common\helpers;

class BootstrapHelper
{
    public static function displayEvent($params_obj)
    {
        echo '<div class="col-sm-6 col-xs-6 col-md-4 col-lg-3  item">
                <div class="event-item">
                    <div class="event-img">
                        <img src="' . $params_obj['img'] . '" class="img-responsive"/>
                    </div>
                    <div class="event-body">
                        <img class="media-object img-circle owner-img" width="50" title="Елена беркова" src="../images/users/1201985170_1201735663_img79325.jpg"  alt="Беркова">
                        <div class="event-title">' . $params_obj['title'] . '</div>
                        <div class="event-description"> ' . $params_obj['description'] . ' </div>
                        <span>
                        <i class="md  md-check" style="font-size: 35px; color: green;"></i>
                        </span>
                        <span>
                            <i class="md md-more-horiz" style="font-size: 35px; color: darkorange;"></i>
                        </span>
                    </div>
                </div>
            </div>';
    }

    public static function renderPopup($title = null, $modal_body = null, $data = null)
    {   echo '<div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">'.$title.'</h4>
                  </div>
                  <div class="modal-body">
                    <p>'. $modal_body .'</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div>
                </div>
              </div>';
    }
}