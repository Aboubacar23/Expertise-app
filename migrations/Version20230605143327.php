<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605143327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point_fonctionnement_rotor ADD u DOUBLE PRECISION NOT NULL, ADD i1 DOUBLE PRECISION NOT NULL, ADD i2 DOUBLE PRECISION NOT NULL, ADD i3 DOUBLE PRECISION NOT NULL, ADD imoy DOUBLE PRECISION NOT NULL, ADD pabs DOUBLE PRECISION NOT NULL, ADD pjoule DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point_fonctionnement_rotor DROP u, DROP i1, DROP i2, DROP i3, DROP imoy, DROP pabs, DROP pjoule');
    }
}
