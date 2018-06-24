<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 25.04.2016
 * Time: 18:45
 */

namespace console\controllers;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные

        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // add "deletePost" permission
        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Delete post';
        $auth->add($deletePost);

        // add "like" permission
        $like = $auth->createPermission('like');
        $like->description = 'action like';
        $auth->add($like);

        // add "comment" permission
        $comment = $auth->createPermission('comment');
        $comment->description = 'action comment';
        $auth->add($comment);

        // add "admin" permission
        $manage = $auth->createPermission('manage');
        $manage->description = 'action manage';
        $auth->add($manage);

        // add "AdvetiserProfile" permission
        $advetiserProfile = $auth->createPermission('advetiserProfile');
        $advetiserProfile->description = 'Advetiser Profile';
        $auth->add($advetiserProfile);

        // add "NonAdvetiserProfile" permission
        $nonAdvetiserProfile = $auth->createPermission('nonAdvetiserProfile');
        $nonAdvetiserProfile->description = 'Non Advetiser Profile';
        $auth->add($nonAdvetiserProfile);

        // add "MakeBookingRequest" permission
        $makeBookingRequest = $auth->createPermission('makeBookingRequest');
        $makeBookingRequest->description = 'Make Booking Request';
        $auth->add($makeBookingRequest);

        // add "ConfirmBookingRequest" permission
        $confirmBookingRequest = $auth->createPermission('confirmBookingRequest');
        $confirmBookingRequest->description = 'Confirm Booking Request';
        $auth->add($confirmBookingRequest);

        // add "Advetiser" role and give this role the "like" permission
        $advetiser = $auth->createRole('Advetiser');
        $auth->add($advetiser);
        $auth->addChild($advetiser, $like);
        $auth->addChild($advetiser, $comment);
        $auth->addChild($advetiser, $advetiserProfile);
        $auth->addChild($advetiser, $confirmBookingRequest);

        // add "NON Advertiser" role and give this role the "createPost" permission
        $non_advetiser = $auth->createRole('NON Advetiser');
        $auth->add($non_advetiser);
        $auth->addChild($non_advetiser, $createPost);
        $auth->addChild($non_advetiser, $updatePost);
        $auth->addChild($non_advetiser, $deletePost);
        $auth->addChild($non_advetiser, $nonAdvetiserProfile);
        $auth->addChild($non_advetiser, $makeBookingRequest);



        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        //$auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $advetiser);
        $auth->addChild($admin, $manage);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
       // $auth->assign($admin, 1);
       // $auth->assign($advetiser,33);
       // $auth->assign($non_advetiser,32);
       // $auth->assign($non_advetiser,35);
       // $auth->assign($non_advetiser,36);


        // Consol command ->
        // yii rbac/init
    }
    public function actionDelete()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные
    }
}