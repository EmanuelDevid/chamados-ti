<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\TicketType;
use App\Models\TicketSubtype;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class HelpdeskSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Setores da SEDHAS (Fixos)
        $departments = [
            ['name' => 'CRAS Aracatiaçu', 'code' => 'CRAS-ARA', 'is_critical' => false],
            ['name' => 'Casa do Cidadão', 'code' => 'CASA-CID', 'is_critical' => true],
            ['name' => 'CRAS Regina Justa', 'code' => 'CRAS-RJ', 'is_critical' => false],
            ['name' => 'Anexo Caiçara', 'code' => 'ANX-CAI', 'is_critical' => false],
            ['name' => 'CRAS Mimi Marinho', 'code' => 'CRAS-MM', 'is_critical' => false],
            ['name' => 'CRAS Irmã Oswalda', 'code' => 'CRAS-IO', 'is_critical' => false],
            ['name' => 'CRAS Dom José', 'code' => 'DOM-JOSE', 'is_critical' => false],
            ['name' => 'CRAS Jaibaras', 'code' => 'CRAS-JAI', 'is_critical' => false],
            ['name' => 'SEDHAS (Sede)', 'code' => 'SEDHAS', 'is_critical' => true],
            ['name' => 'CREAS e Escritório Social', 'code' => 'CREAS-ES', 'is_critical' => true],
            ['name' => 'Conselho Tutelar', 'code' => 'CT', 'is_critical' => true],
            ['name' => 'Almoxarifado – SEDHAS', 'code' => 'ALMOX', 'is_critical' => false],
            ['name' => 'Acolhimento Adulto', 'code' => 'ACOLH-ADU', 'is_critical' => true],
            ['name' => 'Acolhimento Infantil', 'code' => 'ACOLH-INF', 'is_critical' => true],
            ['name' => 'Centro POP', 'code' => 'POP', 'is_critical' => true],
            ['name' => 'Pousada Social', 'code' => 'POUS', 'is_critical' => true],
            ['name' => 'Centro do Idoso', 'code' => 'CENTRO-IDO', 'is_critical' => false],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(
                ['code' => $dept['code']],
                $dept
            );
        }

        // 2. Tipos e Subtipos da TI SEDHAS (Fixos)
        $categories = [
            [
                'name' => 'Sistemas e Contas',
                'description' => 'Ajustes no SIGEP, criação de e-mails institucionais e acessos.',
                'subtypes' => [
                    ['name' => 'Criar / Alterar E-mail Institucional', 'weight' => 1],
                    ['name' => 'Criar / Alterar E-mail de Grupo', 'weight' => 1],
                    ['name' => 'SIGEP - Solicitação de alteração / ajuste no sistema', 'weight' => 2],
                    ['name' => 'SIGEP - Erro ou comportamento indevido em tela', 'weight' => 4],
                    ['name' => 'Redefinição de senha ou problemas de login', 'weight' => 1],
                ]
            ],
            [
                'name' => 'Hardware e Computadores',
                'description' => 'Computadores que pararam, não ligam, travamentos e periféricos.',
                'subtypes' => [
                    ['name' => 'Computador não liga / parou de funcionar', 'weight' => 5],
                    ['name' => 'Lentidão extrema ou travamentos frequentes', 'weight' => 3],
                    ['name' => 'Teclado, mouse ou monitor com defeito', 'weight' => 1],
                    ['name' => 'Nobreak / Estabilizador apitando ou queimado', 'weight' => 4],
                    ['name' => 'Ponto com problema', 'weight' => 4]
                ]
            ],
            [
                'name' => 'Rede e Conectividade',
                'description' => 'Sem conexão de internet ou problemas em pontos de rede.',
                'subtypes' => [
                    ['name' => 'Computador sem acesso à internet / rede local', 'weight' => 3],
                    ['name' => 'Setor inteiro sem acesso à internet', 'weight' => 5],
                    ['name' => 'Cabo de rede danificado ou desconectado', 'weight' => 2],
                    ['name' => 'Mudança ou instalação de ponto de rede', 'weight' => 2],
                ]
            ],
            [
                'name' => 'Impressoras e Suprimentos',
                'description' => 'Troca de toner, impressora não imprime ou desconfigurada.',
                'subtypes' => [
                    ['name' => 'Impressora não imprime / Offline', 'weight' => 3],
                    ['name' => 'Acabou o Toner / Solicitação de novo toner', 'weight' => 2],
                    ['name' => 'Atolamento de papel ou barulho estranho', 'weight' => 2],
                    ['name' => 'Configurar impressora em novo computador', 'weight' => 1],
                ]
            ],
        ];

        foreach ($categories as $cat) {
            $type = TicketType::firstOrCreate(
                ['name' => $cat['name']],
                ['description' => $cat['description']]
            );

            foreach ($cat['subtypes'] as $sub) {
                TicketSubtype::firstOrCreate(
                    [
                        'ticket_type_id' => $type->id,
                        'name' => $sub['name']
                    ],
                    ['weight' => $sub['weight']]
                );
            }
        }

        // 3. Usuário de teste
        $user = User::firstOrCreate(
            ['email' => 'servidor@sobral.ce.gov.br'],
            ['name' => 'Servidor Teste', 'password' => bcrypt('12345678')]
        );

        // 4. Chamados de Exemplo para Teste
        $sampleTickets = [
            [
                'protocol' => date('Ymd') . '000001',
                'dept_code' => 'CRAS-ARA',
                'type_name' => 'Hardware e Computadores',
                'subtype_name' => 'Computador não liga / parou de funcionar',
                'subject' => 'Computador do cadastro não liga',
                'description' => 'A máquina pisca o led da frente, mas não dá vídeo nem inicia o sistema.',
                'scope' => 'individual',
                'priority' => 'critical',
                'status' => 'novo',
            ],
            [
                'protocol' => date('Ymd') . '000002',
                'dept_code' => 'CASA-CID',
                'type_name' => 'Sistemas e Contas',
                'subtype_name' => 'SIGEP - Erro ou comportamento indevido em tela',
                'subject' => 'Erro ao tentar finalizar cadastro de beneficiário',
                'description' => 'Ao clicar em salvar no SIGEP, a tela exibe uma mensagem de erro 500 e fecha o sistema.',
                'scope' => 'individual',
                'priority' => 'high',
                'status' => 'em_atendimento',
            ],
            [
                'protocol' => date('Ymd') . '000003',
                'dept_code' => 'CREAS-ES',
                'type_name' => 'Rede e Conectividade',
                'subtype_name' => 'Setor inteiro sem acesso à internet',
                'subject' => 'Queda total de conexão na recepção do CREAS',
                'description' => 'Nenhum computador da recepção está conseguindo navegar ou acessar a rede local desde às 08h.',
                'scope' => 'sector',
                'priority' => 'critical',
                'status' => 'novo',
            ],
            [
                'protocol' => date('Ymd') . '000004',
                'dept_code' => 'CRAS-RJ',
                'type_name' => 'Impressoras e Suprimentos',
                'subtype_name' => 'Acabou o Toner / Solicitação de novo toner',
                'subject' => 'Substituição de toner da recepção principal',
                'description' => 'A impressora HP está apresentando mensagem de toner fraco e as impressões estão saindo falhadas.',
                'scope' => 'individual',
                'priority' => 'medium',
                'status' => 'aguardando_usuario',
            ],
            [
                'protocol' => date('Ymd') . '000005',
                'dept_code' => 'CT',
                'type_name' => 'Hardware e Computadores',
                'subtype_name' => 'Teclado, mouse ou monitor com defeito',
                'subject' => 'Teclado do atendimento com teclas falhando',
                'description' => 'As teclas Barra de Espaço e Enter do computador de atendimento pararam de responder.',
                'scope' => 'individual',
                'priority' => 'low',
                'status' => 'resolvido',
            ],
        ];

        foreach ($sampleTickets as $tData) {
            $dept = Department::where('code', $tData['dept_code'])->first();
            $type = TicketType::where('name', $tData['type_name'])->first();
            $subtype = TicketSubtype::where('name', $tData['subtype_name'])->first();

            if ($dept && $type && $subtype) {
                Ticket::firstOrCreate(
                    ['protocol' => $tData['protocol']],
                    [
                        'user_id' => $user->id,
                        'department_id' => $dept->id,
                        'ticket_type_id' => $type->id,
                        'ticket_subtype_id' => $subtype->id,
                        'subject' => $tData['subject'],
                        'description' => $tData['description'],
                        'scope' => $tData['scope'],
                        'priority' => $tData['priority'],
                        'status' => $tData['status'],
                    ]
                );
            }
        }
    }
}