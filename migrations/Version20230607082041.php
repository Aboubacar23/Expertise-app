<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607082041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remontage_finition ADD controle_plaque2 VARCHAR(255) DEFAULT NULL, ADD controle_plaque3 VARCHAR(255) DEFAULT NULL, DROP controle_plaques2, DROP controle_plaques3');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remontage_finition ADD controle_plaques2 VARCHAR(255) DEFAULT NULL, ADD controle_plaques3 VARCHAR(255) DEFAULT NULL, DROP controle_plaque2, DROP controle_plaque3');
    }
}
