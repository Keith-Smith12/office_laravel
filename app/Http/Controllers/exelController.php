<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class exelController extends Controller
{
    // PEGAR TODOS OS USUÁRIOS E ENVIAR PARA UM ARQUIVO EXCEL
    public function generateExcel()
    {

        $data['users'] = User::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Renderizar a view e capturar o conteúdo
        $view = view('exel', $data)->render();

        // Carregar o conteúdo HTML na planilha
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($view);

        // Criar um escritor Xlsx
        $writer = new Xlsx($spreadsheet);

        // Definir o nome do arquivo
        $fileName = 'Lista de Usuário.xlsx';

        // Enviar os cabeçalhos apropriados para abrir o arquivo no navegador
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: inline; filename="' . $fileName . '"');  // Modificado para "inline" em vez de "attachment"
        header('Cache-Control: max-age=0');

        // Salvar o arquivo na saída
        $writer->save('php://output');
        exit;
    }

    //mOSTRAR O FORMULÁRIO PARA O CADASTRO DE EM MASSA
    public function mostrarFormulario()
{
    return view('users.create.index1'); // Aqui você vai criar a view 'users.upload'
}


    /*Verificação e Envio de dados    */
    public function enviar(Request $request)
{
    $request->validate([
        'arquivo' => 'required|file|mimes:xlsx,xls,csv|max:2048', // Validação do arquivo
    ]);

    // Processar o arquivo e movê-lo para a pasta public
    $caminho = $request->file('arquivo')->move(public_path('arquivos'), $request->file('arquivo')->getClientOriginalName());

    // Gerar um hash do arquivo para garantir que ele não seja processado novamente
    $hashArquivo = hash_file('sha256', $caminho); // Usando o caminho correto

    // Verificar se esse hash já foi registrado
    $arquivoProcessado = Cache::get("arquivo_processado_{$hashArquivo}");

    if ($arquivoProcessado) {
        return back()->with('error', 'Este arquivo já foi processado.');
    }

    // Armazenar o hash no cache para não processar novamente
    Cache::put("arquivo_processado_{$hashArquivo}", true, now()->addHours(24)); // Expira após 24 horas

    // Chamar a função para ler e cadastrar os dados
    $this->ler($caminho); // Passando o caminho correto

    return back()->with('success', 'Arquivo enviado e processado com sucesso!');
}

public function ler($arquivo)
{
    // Carregar os dados do arquivo Excel
    $dados = IOFactory::createReaderForFile($arquivo)
        ->setReadDataOnly(true)
        ->load($arquivo)
        ->getActiveSheet()
        ->toArray();

    // Iterar pelos dados e cadastrar no banco
    foreach ($dados as $linha) {
        // Validar os dados antes de criar o usuário
        $validator = Validator::make([
            'name' => $linha[0],
            'email' => $linha[1],
            'password' => $linha[2],
        ], [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users,email', // Garantir que o email é único
            'password' => 'required|min:8', // Ajuste a regra conforme necessário
        ]);

        if ($validator->fails()) {
            // Tratar falhas de validação (exemplo: log, lançar exceção, etc.)
            continue; // Ignora a linha se a validação falhar
        }

        // Criar o usuário
        User::create([
            'name' => $linha[0],
            'email' => $linha[1],
            'password' => bcrypt($linha[2]), // Use bcrypt para criptografar a senha
        ]);
    }
}




}
