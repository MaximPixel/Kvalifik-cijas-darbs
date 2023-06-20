<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\ManfRole;
use App\Models\ManfRoleUser;

use Illuminate\Validation\ValidationException;

class ManfRoleController extends Controller {

    public function view(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "edit") {
                $manfRole = ManfRole::firstCodeOrFail($request->get("code"));

                if ($manfRole->canEdit($request->user())) {
                    return view("model.manf.role.edit", ["manfRole" => $manfRole]);
                }
            } else if ($action == "remove-user") {
                $manfRole = ManfRole::firstCodeOrFail($request->get("code"));

                if ($manfRole->canEdit($request->user())) {
                    $user = User::firstCodeOrFail($request->get("user"));

                    $manfRoleUser = ManfRoleUser::query()
                        ->where("manf_role_id", $manfRole->id)
                        ->where("user_id", $user->id)
                        ->firstOrFail();

                    $manfRoleUser->delete();

                    return autoredirect();
                }
            } else if ($action == "delete") {
                $manfRole = ManfRole::firstCodeOrFail($request->get("code"));

                if ($manfRole->canEdit($request->user())) {
                    return view("yesno");
                }
            }
        }
        abort(404);
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->get("action");

            if ($action == "add-user") {
                $manfRole = ManfRole::firstCodeOrFail($request->get("code"));

                if ($manfRole->canEdit($request->user())) {
                    $userEmail = $request->get("userEmail");

                    $user = User::where("email", $userEmail)->first();

                    if (!$user) {
                        throw ValidationException::withMessages(["userEmail" => __("validation.manf-role.user-not-found")]);
                    }

                    if ($manfRole->manfRoleUsers->where("user_id", $user->id)->isNotEmpty()) {
                        throw ValidationException::withMessages(["userEmail" => __("validation.manf-role.user-already-exists")]);
                    }

                    $manfRoleUser = new ManfRoleUser;
                    $manfRoleUser->manf_role_id = $manfRole->id;
                    $manfRoleUser->user_id = $user->id;
                    $manfRoleUser->save();

                    return autoredirect();
                }
            } else if ($action == "delete") {
                $manfRole = ManfRole::firstCodeOrFail($request->get("code"));

                if ($manfRole->canEdit($request->user())) {
                    foreach ($manfRole->manfRoleUsers as $manfRoleUser) {
                        $manfRoleUser->delete();
                    }

                    $manfRole->delete();

                    return autoredirect();
                }
            }
        }
        abort(404);
    }
}
