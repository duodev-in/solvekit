<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConstructionDataTest extends TestCase
{
    public function test_nec_resistances_agree_with_conductor_resistivity(): void
    {
        // Table 8 at 75 °C follows K ÷ circular mils: K ≈ 12.9 Ω·cmil/ft for copper and 21.2 for aluminum.
        foreach (config('construction_data.wires') as $size => $wire) {
            $this->assertEqualsWithDelta(1, $wire['r_cu'] / (12.9e3 / $wire['cmil']), 0.01, "{$size} copper");
            $this->assertEqualsWithDelta(1, $wire['r_al'] / (21.2e3 / $wire['cmil']), 0.01, "{$size} aluminum");
        }
    }

    public function test_ampacity_and_conductor_area_grow_with_size(): void
    {
        $previous = null;

        foreach (config('construction_data.wires') as $size => $wire) {
            $this->assertLessThanOrEqual($wire['amp_cu'][1], $wire['amp_cu'][0], "{$size} 60 °C ≤ 75 °C");
            $this->assertLessThanOrEqual($wire['amp_cu'][2], $wire['amp_cu'][1], "{$size} 75 °C ≤ 90 °C");

            if ($previous) {
                $this->assertGreaterThan($previous['cmil'], $wire['cmil'], $size);
                $this->assertGreaterThanOrEqual($previous['amp_cu'][1], $wire['amp_cu'][1], $size);
                $this->assertGreaterThan($previous['area']['thhn'], $wire['area']['thhn'], $size);
            }

            $previous = $wire;
        }

        $this->assertSame([15, 20, 25], config('construction_data.wires.14.amp_cu'));
        $this->assertSame([195, 230, 260], config('construction_data.wires.4/0.amp_cu'));
    }

    public function test_pipe_schedules_get_thicker(): void
    {
        foreach (config('construction_data.pipe.sizes') as $nps => $pipe) {
            $walls = array_values(array_filter([$pipe['wall']['10'], $pipe['wall']['40'], $pipe['wall']['80'], $pipe['wall']['160']]));

            $this->assertSame($walls, collect($walls)->sort()->values()->all(), "NPS {$nps}");
            $this->assertLessThan($pipe['od'] / 2, max($walls), "NPS {$nps}");
        }

        $this->assertSame(0.154, config('construction_data.pipe.sizes.2.wall.40'));
        $this->assertSame(2.375, config('construction_data.pipe.sizes.2.od'));
    }

    public function test_rebar_weights_match_steel_density(): void
    {
        // 1 in² of steel 1 ft long at 490 lb/ft³ weighs 3.40 lb.
        foreach (config('construction_data.rebar.us') as $bar => $data) {
            $this->assertEqualsWithDelta($data['area'] * 490 / 144, $data['weight'], $data['weight'] * 0.03, $bar);
        }

        // Metric bars: 7850 kg/m³ × π d² ÷ 4.
        foreach (config('construction_data.rebar.metric') as $bar => $data) {
            $this->assertEqualsWithDelta(7850 * M_PI * ($data['diameter'] / 1000) ** 2 / 4, $data['mass'], $data['mass'] * 0.01, $bar);
        }
    }

    public function test_bulk_materials_are_lighter_loose_than_in_place(): void
    {
        foreach (config('construction_data.bulk') as $key => $material) {
            $this->assertNotEmpty($material['name']);
            $this->assertLessThan($material['bank'], $material['loose'], $key);
        }

        foreach (config('construction_data.products') as $key => $product) {
            $this->assertArrayHasKey($product['bulk'], config('construction_data.bulk'), $key);
        }
    }

    public function test_thread_and_clearance_tables_are_consistent(): void
    {
        foreach (config('construction_data.threads_metric') as $name => $thread) {
            $this->assertLessThan($thread['coarse'], $thread['fine'], $name);
            $this->assertGreaterThan($thread['major'], $thread['clearance']['fine'], $name);
            $this->assertLessThanOrEqual($thread['clearance']['medium'], $thread['clearance']['fine'], $name);
            $this->assertLessThanOrEqual($thread['clearance']['coarse'], $thread['clearance']['medium'], $name);
        }

        foreach (config('construction_data.threads_inch') as $name => $thread) {
            if (isset($thread['clearance'])) {
                $this->assertGreaterThan($thread['major'], $thread['clearance']['close']['diameter'], $name);
                $this->assertLessThan($thread['clearance']['free']['diameter'], $thread['clearance']['close']['diameter'], $name);
            }

            if (isset($thread['tap_drill'])) {
                $this->assertLessThan($thread['major'], $thread['tap_drill']['diameter'], $name);
            }
        }
    }

    public function test_wood_species_carry_handbook_values(): void
    {
        foreach (config('construction_data.wood') as $key => $wood) {
            $this->assertGreaterThan(0.2, $wood['sg_green'], $key);
            $this->assertGreaterThanOrEqual($wood['sg_green'], $wood['sg_12'], $key);
            $this->assertGreaterThan(4000, $wood['e_12'], $key);
        }

        $this->assertSame(0.45, config('construction_data.wood.douglas_fir.sg_green'));
        $this->assertSame(13400, config('construction_data.wood.douglas_fir.e_12'));
    }

    public function test_box_fill_tables_match_nec_314_16(): void
    {
        $this->assertSame(['18' => 1.5, '16' => 1.75, '14' => 2.0, '12' => 2.25, '10' => 2.5, '8' => 3.0, '6' => 5.0], config('construction_data.box_fill.allowance'));
        $this->assertSame(['4 × 1½ in square', 21.0], config('construction_data.box_fill.boxes.square_4_112'));
    }
}
