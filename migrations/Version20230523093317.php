<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523093317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre ADD controle_visuel_electrique_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041963DA692 FOREIGN KEY (controle_visuel_electrique_id) REFERENCES controle_visuel_electrique (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC79041963DA692 ON parametre (controle_visuel_electrique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041963DA692');
        $this->addSql('DROP INDEX UNIQ_ACC79041963DA692 ON parametre');
        $this->addSql('ALTER TABLE parametre DROP controle_visuel_electrique_id');
    }
}
