<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marque;
/**
@OA\Info(
    title="APIs For Thrift Store",
    version="1.0.0",
),
@OA\SecurityScheme(
    securityScheme="bearerAuth",
    in="header",
    name="bearerAuth",
    type="http",
    scheme="bearer",
    bearerFormat="JWT",
),
 */

class MarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @OA\Get(
     *     path="/api/marques",
     *     summary="Récupérer la liste des marques",
     *     tags={"Marques"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des marques récupérée avec succès"
     *     )
     * )
     */
    public function index()
    {
        $marques = Marque::all();
        return view('marques.index', compact('marques'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @OA\Get(
     *     path="/api/marques/create",
     *     summary="Obtenir les données pour créer une marque",
     *     tags={"Marques"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des marques retournée"
     *     )
     * )
     */
    public function create()
    {
        $marque = Marque::all();
        return response()->json($marque);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @OA\Post(
     *     path="/api/marques",
     *     summary="Créer une nouvelle marque",
     *     tags={"Marques"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom", "description", "logo"},
     *             @OA\Property(property="nom", type="string", example="Nike"),
     *             @OA\Property(property="description", type="string", example="Marque de vêtements sportifs"),
     *             @OA\Property(property="logo", type="string", example="nike_logo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Marque créée avec succès"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'required|string|max:15|unique:marques',
        ]);

        $marque = Marque::create($request->all());

        return response()->json([
            'message' => 'Marque créée avec succès',
            'marque' => $marque
        ], 201);
    }

    /**
     * Display the specified resource.
     * 
     * @OA\Get(
     *     path="/api/marques/{id}",
     *     summary="Afficher une marque spécifique",
     *     tags={"Marques"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la marque",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Marque trouvée"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Marque non trouvée"
     *     )
     * )
     */
    public function show(string $id)
    {
        $marque = Marque::find($id);
        
        if (!$marque) {
            return response()->json(['message' => 'Marque non trouvée'], 404);
        }
        
        return view('marques.show', compact('marque'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @OA\Get(
     *     path="/api/marques/{id}/edit",
     *     summary="Formulaire d'édition d'une marque",
     *     tags={"Marques"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la marque",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formulaire d'édition"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Marque non trouvée"
     *     )
     * )
     */
    public function edit(string $id)
    {
        $marque = Marque::find($id);
        
        if (!$marque) {
            return response()->json(['message' => 'Marque non trouvée'], 404);
        }
        
        return view('marques.edit', compact('marque'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @OA\Put(
     *     path="/api/marques/{id}",
     *     summary="Mettre à jour une marque",
     *     tags={"Marques"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la marque",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nom", type="string", example="Nike Updated"),
     *             @OA\Property(property="description", type="string", example="Description mise à jour"),
     *             @OA\Property(property="logo", type="string", example="nike_logo_new")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Marque mise à jour avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Marque non trouvée"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function update(Request $request, string $id)
    {
        $marque = Marque::find($id);

        if (!$marque) {
            return response()->json(['message' => 'Marque non trouvée'], 404);
        }

        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'logo' => 'sometimes|string|max:15|unique:marques,logo,' . $marque->id,
        ]);

        $marque->update($request->all());

        return response()->json([
            'message' => 'Marque mise à jour avec succès',
            'marque' => $marque
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @OA\Delete(
     *     path="/api/marques/{id}",
     *     summary="Supprimer une marque",
     *     tags={"Marques"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la marque",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Marque supprimée avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Marque non trouvée"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function destroy(string $id)
    {
        $marque = Marque::find($id);

        if (!$marque) {
            return response()->json(['message' => 'Marque non trouvée'], 404);
        }

        $marque->delete();

        return response()->json(['message' => 'Marque supprimée avec succès']);
    }
}