<?php

namespace App\Http\Controllers\Identity;

use App\Http\Controllers\Controller;
use App\Models\AcceptedDocument;
use App\Models\IdentityDocument;
use App\Models\User;
use App\Providers\Events\IdentityDocumentSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
  // Get accepted document types
  public function acceptedDocuments()
  {
    $documents = AcceptedDocument::all();
    return response()->json($documents, 200);
  }

  // User's identity document
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
      'type_id' => 'required|exists:accepted_documents,id',
      'name_on_document' => 'required|string|max:255',
      'document_number' => 'required|string|max:255',
      'document_expiry' => 'nullable|date',
      'file' => 'required',
    ]);
    // TODO: |file|mimes:jpeg,png,jpg|max:2048'
    if ($validator->fails())
      return response(['status' => false, 'message' => $validator->errors()->first()], 400);

    $user = User::find($request->user_id);
    if ($user->identified)
      return response()->json(['status' => false, 'message' => 'User already has an identity document'], 200);
    
    $document_type = AcceptedDocument::where('id', $request->type_id)->first();

    if (! $request->hasFile('file')) {
      // $file = $request->file('file');
      // $file_name = 'user_' . $user->id .'_' . $document_type->document_type . '.' . $file->getClientOriginalExtension();

      // $file->storeAs('identitydocuments/', $file_name);

      $file_name = 'file_will_upload.jpeg';

      $submited = IdentityDocument::create([
        'user_id' => $request->user_id,
        'type_id' => $request->type_id,
        'name_on_document' => $request->name_on_document,
        'document_number' => $request->document_number,
        'document_expiry' => $request->document_expiry,
        'file_name' =>  $file_name,
        'file_type' => $request->file, //->getClientOriginalExtension()
        'file_url' => '/uploads/identitydocuments/' . $file_name
      ]);
    }

    event(new IdentityDocumentSubmitted($user, $submited));
    // TODO: Send email to user and admin to notify of submission

    return response(['status' => true, 'message' => 'Document submitted'], 200);
  }
}
