<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531120814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE controle_montage_conssinet ADD d1 DOUBLE PRECISION DEFAULT NULL, ADD d2 DOUBLE PRECISION DEFAULT NULL, ADD d3 DOUBLE PRECISION DEFAULT NULL, ADD d4 DOUBLE PRECISION DEFAULT NULL, ADD d5 DOUBLE PRECISION DEFAULT NULL, ADD d6 DOUBLE PRECISION DEFAULT NULL, ADD d7 DOUBLE PRECISION DEFAULT NULL, ADD d8 DOUBLE PRECISION DEFAULT NULL, ADD d9 DOUBLE PRECISION DEFAULT NULL, ADD d10 DOUBLE PRECISION DEFAULT NULL, ADD d11 DOUBLE PRECISION DEFAULT NULL, ADD d12 DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE controle_montage_conssinet DROP d1, DROP d2, DROP d3, DROP d4, DROP d5, DROP d6, DROP d7, DROP d8, DROP d9, DROP d10, DROP d11, DROP d12');
    }
}
