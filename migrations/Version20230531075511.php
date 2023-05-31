<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531075511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accessoire_supplementaire ADD lig INT DEFAULT NULL');
        $this->addSql('ALTER TABLE controle_visuel_mecanique DROP lig');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accessoire_supplementaire DROP lig');
        $this->addSql('ALTER TABLE controle_visuel_mecanique ADD lig INT DEFAULT NULL');
    }
}
