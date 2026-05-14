<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Parcela;
use App\Models\Cultivo;
use App\Models\Zafra;
use App\Models\Producto;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios
        User::create([
            'name' => 'Admin AGROTRACK',
            'email' => 'admin@agrotrack.com',
            'password' => Hash::make('admin123'),
            'role' => 'Admin',
            'telefono' => '0981 000 000',
        ]);

        User::create([
            'name' => 'Ing. Técnico A',
            'email' => 'tecnico@agrotrack.com',
            'password' => Hash::make('tec123'),
            'role' => 'Tecnico',
            'telefono' => '0981 111 111',
        ]);

        User::create([
            'name' => 'Ing. Técnico B',
            'email' => 'tecnico2@agrotrack.com',
            'password' => Hash::make('tec123'),
            'role' => 'Tecnico',
            'telefono' => '0981 222 222',
        ]);

        User::create([
            'name' => 'Consultor',
            'email' => 'consulta@agrotrack.com',
            'password' => Hash::make('con123'),
            'role' => 'Consulta',
        ]);

        // Cultivos
        Cultivo::create(['nombre' => 'Soja', 'tipo' => 'Verano']);
        Cultivo::create(['nombre' => 'Maíz', 'tipo' => 'Verano']);
        Cultivo::create(['nombre' => 'Sorgo', 'tipo' => 'Verano']);
        Cultivo::create(['nombre' => 'Canola', 'tipo' => 'Invierno']);
        Cultivo::create(['nombre' => 'Avena', 'tipo' => 'Cobertura']);
        Cultivo::create(['nombre' => 'Cobertura', 'tipo' => 'Cobertura']);
        Cultivo::create(['nombre' => 'Pastura', 'tipo' => 'Forrajero']);
        Cultivo::create(['nombre' => 'Algodón', 'tipo' => 'Verano']);

        // Zafras
        Zafra::create([
            'nombre' => 'Zafra 2024-2025',
            'fecha_inicio' => '2024-08-01',
            'fecha_fin' => '2025-01-31',
            'activa' => false,
        ]);
        Zafra::create([
            'nombre' => 'Safrinha 2025',
            'fecha_inicio' => '2025-02-01',
            'fecha_fin' => '2025-06-30',
            'activa' => false,
        ]);
        Zafra::create([
            'nombre' => 'Zafra 2025-2026',
            'fecha_inicio' => '2025-08-01',
            'fecha_fin' => '2026-01-31',
            'activa' => true,
        ]);
        Zafra::create([
            'nombre' => 'Safrinha 2026',
            'fecha_inicio' => '2026-02-01',
            'fecha_fin' => '2026-06-30',
            'activa' => true,
        ]);

        // Productos (basado en catalogo real)
        $productos = [
            ['Glifosato 75%', 'HERBICIDA', 'L', 1.7, 4.9],
            ['2,4 D 96%', 'HERBICIDA', 'Kg', 0.7, 5.2],
            ['Cletodim 36%', 'HERBICIDA', 'L', 0.35, 8.4],
            ['Metribuzine 75%', 'HERBICIDA', 'L', 0.8, 13.2],
            ['Sulfentrazone 50%', 'HERBICIDA', 'L', 0.7, 23.0],
            ['Paraquat 27%', 'HERBICIDA', 'L', 5.5, 2.5],
            ['Triclopyr 48%', 'HERBICIDA', 'L', 1.0, 8.5],
            ['Glufosinato 40%', 'HERBICIDA', 'L', 2.2, 5.2],
            ['Saflufenacil 70%', 'HERBICIDA', 'Kg', 0.05, 205.0],
            ['Fomesafen 25%', 'HERBICIDA', 'L', 1.0, 7.4],
            ['Clorpiralid 48%', 'HERBICIDA', 'L', 0.2, 18.5],
            ['Triflumuron 48%', 'INSECTICIDA', 'L', 0.5, 25.5],
            ['Bifentrin 40%', 'INSECTICIDA', 'L', 1.0, 15.0],
            ['Lambdacialotrina 25%', 'INSECTICIDA', 'L', 0.4, 11.0],
            ['Abamectina 8,4%', 'INSECTICIDA', 'L', 0.2, 24.0],
            ['Metomil 90%', 'INSECTICIDA', 'Kg', 0.3, 16.5],
            ['Thiametoxan 75%', 'INSECTICIDA', 'Kg', 0.8, 13.0],
            ['Acefato 97%', 'INSECTICIDA', 'Kg', 1.0, 10.0],
            ['Fidresa', 'FUNGICIDA', 'L', 0.7, 44.0],
            ['Tebuconazole 43%', 'FUNGICIDA', 'L', 0.4, 7.8],
            ['Difenoconazole 25%', 'FUNGICIDA', 'L', 0.3, 12.0],
            ['Prosoy T', 'FUNGICIDA', 'L', 1.0, 22.0],
            ['Zaltus', 'FUNGICIDA', 'L', 0.7, 38.0],
            ['Clorotalonil', 'FUNGICIDA', 'L', 4.5, 6.8],
            ['Mancozeb', 'FUNGICIDA', 'Kg', 1.5, 6.3],
            ['Gunter', 'FUNGICIDA', 'L', 0.5, 18.0],
            ['Proflex', 'ADHERENTE', 'L', 0.2, 15.5],
            ['Aceite Vegetal', 'ADHERENTE', 'L', 1.2, 3.5],
            ['Nitroil', 'ADHERENTE', 'L', 1.5, 3.8],
            ['Profix', 'ADHERENTE', 'L', 0.1, 18.0],
            ['Fertilizante 11-52-00', 'FERTILIZANTE', 'Tn', 0.155, 850.0],
            ['Boro Granulado', 'FERTILIZANTE', 'Kg', 5.0, 0.9],
            ['Kelat Monin', 'FERTILIZANTE', 'Kg', 0.3, 32.0],
            ['Bio Boro', 'FERTILIZANTE', 'L', 1.5, 5.5],
            ['Bolsa x 40 kg', 'SEMILLA', 'Bol', 1.0, 50.0],
            ['Inoculante', 'SEMILLA', 'Dosis', 3.0, 1.0],
        ];

        foreach ($productos as $p) {
            Producto::create([
                'nombre' => $p[0],
                'categoria' => $p[1],
                'unidad' => $p[2],
                'dosis_referencia' => $p[3],
                'precio_referencia' => $p[4],
            ]);
        }

        // Clientes y parcelas
        $clientesData = [
            'JORGE LUIS KRUG' => [
                ['Parcelo Viudo', 45, 'DM 66I68'],
                ['Parcela Norte', 30, 'DM 66I68'],
                ['Parcela Sur', 25, 'DM 55I52'],
            ],
            'SERGIO MARTYNIUK' => [
                ['Parcela Nita', 10, 'DM 66I68'],
                ['Parcela Loma', 15, 'NA 5909'],
            ],
            'CAATY S.A' => [
                ['Puerto Italia 1', 120, 'NS 75'],
                ['Puerto Italia 2', 85, 'P 30F53'],
            ],
            'TOKORODANI' => [
                ['Parcela 49', 50, 'DM 66I68'],
            ],
            'DM SAN RAFAEL' => [
                ['San Rafael 1', 200, ''],
                ['San Rafael 2', 180, ''],
            ],
            'EL MIRADOR S.A' => [
                ['Lote A', 90, ''],
                ['Lote B', 65, ''],
            ],
            'MARCOS SAUCHUK' => [
                ['Lote Centro', 35, ''],
                ['Lote Este', 28, ''],
            ],
            'DANIEL TISCHLER' => [
                ['Parcela Principal', 40, ''],
            ],
        ];

        foreach ($clientesData as $nombre => $parcelas) {
            $cliente = Cliente::create([
                'nombre' => $nombre,
                'creado_por_user_id' => 1,
            ]);
            foreach ($parcelas as $p) {
                Parcela::create([
                    'cliente_id' => $cliente->id,
                    'nombre' => $p[0],
                    'superficie_ha' => $p[1],
                    'variedad' => $p[2],
                    'cultivo_id' => 1,
                ]);
            }
        }
    }
}
