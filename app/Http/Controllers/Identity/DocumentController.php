<?php

namespace App\Http\Controllers\Identity;

use App\Http\Controllers\Controller;
use App\Models\AcceptedDocument;
use App\Models\IdentityDocument;
use App\Models\User;
use App\Providers\IdentityDocumentSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
  public function acceptedDocuments()
  {
    $documents = AcceptedDocument::all();
    return response()->json($documents, 200);
  }
  
  public function getDocument($user_id)
  {
    $user = User::find($user_id);
    if (!$user)
      return response()->json(400);
    return response()->json($user->identity_documents, 200);
  }

  // Submit identity document
  public function submitdoc(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      'type_id' => 'required|exists:accepted_documents,document_type',
      'name_on_document' => 'required|string|max:255',
      'document_number' => 'required|string|max:255',
      'document_expiry' => 'nullable|date',
      'file' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
    ]);
    if ($validator->fails())
      return response(['status' => false, 'message' => $validator->errors()->all()], 200);

    $user = User::find($request->user_id);
    $document_type = AcceptedDocument::where('id', $request->type_id)->first();

    if ($request->hasFile('file')) {
      $file = $request->file('file');
      $file_name = 'user_' . $user->id . '_' . $document_type;

      $file->move(public_path('/uploads/identitydocuments/'), $file_name);

      $submited = IdentityDocument::create([
        'user_id' => $request->user_id,
        'type_id' => $request->type_id,
        'name_on_document' => $request->name_on_document,
        'document_number' => $request->document_number,
        'document_expiry' => $request->document_expiry,
        'file_name' =>  $file_name,
        'file_type' => $request->file->getClientOriginalExtension(),
        'file_url' => '/uploads/identitydocuments/' . $file_name
      ]);
    }

    event(new IdentityDocumentSubmitted($user, $submited));
    // TODO: Send email to user and admin to notify of submission

    return response(['status' => true, 'message' => 'Document submitted'], 200);
  }
}
