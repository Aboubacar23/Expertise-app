<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531133748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE controle_geometrique ADD pivot_b1 DOUBLE PRECISION DEFAULT NULL, ADD pivot_b2 DOUBLE PRECISION DEFAULT NULL, ADD pivot_b3 DOUBLE PRECISION DEFAULT NULL, ADD pivot_b4 DOUBLE PRECISION DEFAULT NULL, DROP pivot11, DROP pivot12, DROP pivot13, DROP pivot14');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE controle_geometrique ADD pivot11 DOUBLE PRECISION DEFAULT NULL, ADD pivot12 DOUBLE PRECISION DEFAULT NULL, ADD pivot13 DOUBLE PRECISION DEFAULT NULL, ADD pivot14 DOUBLE PRECISION DEFAULT NULL, DROP pivot_b1, DROP pivot_b2, DROP pivot_b3, DROP pivot_b4');
    }
}
