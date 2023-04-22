<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\UserGroup;

class UserController extends Controller {

    public function view(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "edit") {
                $userModel = User::firstCodeOrFail($request->get("code"));

                if ($userModel->canEdit($request->user())) {
                    return view("model.user.edit", ["user" => $userModel]);
                }
            } else if ($action == "delete") {
                $userModel = User::firstCodeOrFail($request->get("code"));

                if ($userModel->canEdit($request->user())) {
                    return view("yesno");
                }
            }
        } else if ($request->has("code")) {
            $userModel = User::firstCodeOrFail($request->get("code"));

            if ($userModel->canView($request->user())) {
                return view("model.user.view", ["user" => $userModel]);
            }

            abort(404);
        }
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "edit") {
                $userModel = User::firstCodeOrFail($request->get("code"));

                if ($userModel->canEdit($request->user())) {
                    $isAdminEdited = $request->user()->isAdmin();

                    $validateParams = [
                        "name" => [
                            "required",
                            "string",
                            "min:2",
                            "max:255",
                        ],
                        "image" => "file",
                    ];

                    if ($isAdminEdited) {
                        $validateParams["email"] = [
                            "email" => [
                                "required",
                                "email",
                                "max:255",
                            ],
                        ];
                    }

                    $data = $request->validate($validateParams);

                    $userModel->name = $data["name"];

                    $image = $data["image"];

                    if ($image) {
                        $imageModel = \App\Models\Image::upload($image->path());
                        $userModel->image_id = $imageModel->id;
                    }

                    if ($isAdminEdited) {
                        $userModel->email = $data["email"];

                        $password = $request->get("password");

                        if ($password !== null) {
                            $userModel->password = Hash::make($password);
                        }

                        $userGroup = UserGroup::where("name", $request->get("user_group"))->first();

                        if ($userGroup) {
                            $userModel->user_group_id = $userGroup->id;
                        }
                    }

                    if ($userModel->isDirty()) {
                        $userModel->save();
                    }

                    return autoredirect($userModel->getRoute());
                }
            } else if ($action == "delete") {
                $userModel = User::firstCodeOrFail($request->get("code"));

                if ($userModel->canEdit($request->user())) {
                    $userModel->delete();
                    return autoredirect();
                }
            }
        }
    }
}
