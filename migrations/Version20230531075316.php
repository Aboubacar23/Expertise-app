<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531075316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accessoire_supplementaire ADD controle_visuel_mecanique_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE accessoire_supplementaire ADD CONSTRAINT FK_EC302D7F79226542 FOREIGN KEY (controle_visuel_mecanique_id) REFERENCES controle_visuel_mecanique (id)');
        $this->addSql('CREATE INDEX IDX_EC302D7F79226542 ON accessoire_supplementaire (controle_visuel_mecanique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accessoire_supplementaire DROP FOREIGN KEY FK_EC302D7F79226542');
        $this->addSql('DROP INDEX IDX_EC302D7F79226542 ON accessoire_supplementaire');
        $this->addSql('ALTER TABLE accessoire_supplementaire DROP controle_visuel_mecanique_id');
    }
}
