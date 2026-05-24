<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Seed: 20 categorias + 1000 produtos.
 * Usa srand(42) para reprodutibilidade (mesmo dados que o Django).
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Categorias (nome, descrição) — idênticas ao seed Django.
     */
    private array $categories = [
        ['Eletrônicos', 'Dispositivos eletrônicos e gadgets'],
        ['Livros', 'Livros físicos e digitais'],
        ['Roupas', 'Vestuário masculino e feminino'],
        ['Calçados', 'Sapatos, tênis e sandálias'],
        ['Esportes', 'Artigos esportivos e fitness'],
        ['Casa e Jardim', 'Itens para casa e decoração'],
        ['Automotivo', 'Peças e acessórios automotivos'],
        ['Brinquedos', 'Brinquedos e jogos infantis'],
        ['Saúde', 'Produtos de saúde e bem-estar'],
        ['Beleza', 'Cosméticos e cuidados pessoais'],
        ['Alimentos', 'Alimentos e bebidas'],
        ['Ferramentas', 'Ferramentas manuais e elétricas'],
        ['Papelaria', 'Material de escritório e escolar'],
        ['Pet Shop', 'Produtos para animais de estimação'],
        ['Informática', 'Computadores e periféricos'],
        ['Games', 'Jogos e consoles de videogame'],
        ['Música', 'Instrumentos musicais e acessórios'],
        ['Móveis', 'Móveis para casa e escritório'],
        ['Bebês', 'Produtos para bebês e crianças'],
        ['Camping', 'Equipamentos para camping e aventura'],
    ];

    /**
     * Adjetivos para nomes de produtos.
     */
    private array $adjectives = [
        'Premium', 'Ultra', 'Pro', 'Max', 'Lite', 'Plus', 'Super', 'Mega',
        'Mini', 'Classic', 'Digital', 'Smart', 'Power', 'Elite', 'Master',
    ];

    /**
     * Substantivos por categoria.
     */
    private array $nouns = [
        'Eletrônicos'   => ['Smartphone', 'Tablet', 'Fone de Ouvido', 'Smartwatch', 'Câmera', 'Caixa de Som', 'Carregador', 'Cabo USB'],
        'Livros'        => ['Romance', 'Manual Técnico', 'Biografia', 'Ficção Científica', 'Quadrinhos', 'Dicionário', 'Atlas', 'Enciclopédia'],
        'Roupas'        => ['Camiseta', 'Calça Jeans', 'Jaqueta', 'Vestido', 'Bermuda', 'Moletom', 'Camisa Social', 'Saia'],
        'Calçados'      => ['Tênis Esportivo', 'Sapato Social', 'Sandália', 'Bota', 'Chinelo', 'Sapatênis', 'Mocassim', 'Tamanco'],
        'Esportes'      => ['Bola de Futebol', 'Raquete', 'Haltere', 'Esteira', 'Tapete Yoga', 'Luva de Boxe', 'Bicicleta', 'Rede de Vôlei'],
        'Casa e Jardim' => ['Vaso Decorativo', 'Luminária', 'Tapete', 'Cortina', 'Regador', 'Almofada', 'Quadro', 'Relógio de Parede'],
        'Automotivo'    => ['Pneu', 'Óleo Motor', 'Filtro de Ar', 'Lâmpada LED', 'Tapete Carro', 'Cera Automotiva', 'Antena', 'Buzina'],
        'Brinquedos'    => ['Boneca', 'Carrinho', 'Quebra-Cabeça', 'Lego', 'Pelúcia', 'Jogo de Tabuleiro', 'Pião', 'Fantasia'],
        'Saúde'         => ['Vitamina C', 'Termômetro', 'Balança', 'Medidor de Pressão', 'Protetor Solar', 'Band-Aid', 'Colírio', 'Massageador'],
        'Beleza'        => ['Perfume', 'Batom', 'Shampoo', 'Creme Facial', 'Esmalte', 'Rímel', 'Base', 'Hidratante'],
        'Alimentos'     => ['Café Especial', 'Azeite Extra Virgem', 'Chocolate', 'Granola', 'Mel Orgânico', 'Chá Importado', 'Castanha', 'Geleia'],
        'Ferramentas'   => ['Furadeira', 'Chave de Fenda', 'Martelo', 'Alicate', 'Serra', 'Trena', 'Nível', 'Parafusadeira'],
        'Papelaria'     => ['Caderno', 'Caneta', 'Lápis', 'Borracha', 'Agenda', 'Marcador', 'Régua', 'Grampeador'],
        'Pet Shop'      => ['Ração Premium', 'Coleira', 'Brinquedo Pet', 'Cama Pet', 'Shampoo Pet', 'Comedouro', 'Arranhador', 'Guia Retrátil'],
        'Informática'   => ['Monitor', 'Teclado Mecânico', 'Mouse Gamer', 'SSD', 'Memória RAM', 'Placa de Vídeo', 'Webcam', 'Hub USB'],
        'Games'         => ['Controle Gamer', 'Headset Gamer', 'Console', 'Jogo RPG', 'Mousepad XL', 'Cadeira Gamer', 'Volante', 'Arcade Stick'],
        'Música'        => ['Violão', 'Guitarra', 'Teclado Musical', 'Bateria', 'Microfone', 'Amplificador', 'Ukulele', 'Flauta'],
        'Móveis'        => ['Mesa de Escritório', 'Cadeira Ergonômica', 'Estante', 'Sofá', 'Cama Box', 'Guarda-Roupa', 'Cômoda', 'Rack TV'],
        'Bebês'         => ['Carrinho de Bebê', 'Mamadeira', 'Fralda', 'Berço', 'Chupeta', 'Babá Eletrônica', 'Body', 'Mordedor'],
        'Camping'       => ['Barraca', 'Saco de Dormir', 'Lanterna', 'Cantil', 'Fogareiro', 'Mochila 50L', 'Isolante Térmico', 'Bússola'],
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed fixo para reprodutibilidade
        srand(42);

        // Limpar dados existentes
        Product::truncate();
        Category::truncate();

        // Criar 20 categorias
        $categories = [];
        foreach ($this->categories as [$nome, $descricao]) {
            $categories[] = Category::create([
                'nome'      => $nome,
                'descricao' => $descricao,
            ]);
        }

        // Criar 1000 produtos
        $products = [];
        for ($i = 0; $i < 1000; $i++) {
            $categoria = $categories[array_rand($categories)];
            $catNome = $categoria->nome;
            $categoryNouns = $this->nouns[$catNome];
            $noun = $categoryNouns[array_rand($categoryNouns)];
            $adjective = $this->adjectives[array_rand($this->adjectives)];
            $nome = "{$noun} {$adjective} " . ($i + 1);
            $descricao = "Descrição do produto {$nome} na categoria {$catNome}.";
            $preco = round(mt_rand(999, 999999) / 100, 2);
            $estoque = mt_rand(0, 500);

            $products[] = [
                'nome'         => $nome,
                'descricao'    => $descricao,
                'preco'        => $preco,
                'estoque'      => $estoque,
                'categoria_id' => $categoria->id,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        // Bulk insert para performance
        foreach (array_chunk($products, 100) as $chunk) {
            Product::insert($chunk);
        }

        echo "Seed concluído: " . count($categories) . " categorias e " . count($products) . " produtos criados.\n";
    }
}
