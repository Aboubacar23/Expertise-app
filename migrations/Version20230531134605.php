<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531134605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE controle_geometrique ADD tolerie_e1 DOUBLE PRECISION DEFAULT NULL, ADD tolerie_e2 DOUBLE PRECISION DEFAULT NULL, ADD tolerie_e3 DOUBLE PRECISION DEFAULT NULL, ADD tolerie_e4 DOUBLE PRECISION DEFAULT NULL, DROP pivot_e1, DROP pivot_e2, DROP pivot_e3, DROP pivot_e4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE controle_geometrique ADD pivot_e1 DOUBLE PRECISION DEFAULT NULL, ADD pivot_e2 DOUBLE PRECISION DEFAULT NULL, ADD pivot_e3 DOUBLE PRECISION DEFAULT NULL, ADD pivot_e4 DOUBLE PRECISION DEFAULT NULL, DROP tolerie_e1, DROP tolerie_e2, DROP tolerie_e3, DROP tolerie_e4');
    }
}
