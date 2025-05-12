BEGIN;

CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Table Recruiter
CREATE TABLE "recruiter" (
    "id" UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    "firstName" VARCHAR(255) NOT NULL,
    "lastName" VARCHAR(255) NOT NULL,
    "company" VARCHAR(255) NOT NULL,
    "linkedinProfile" VARCHAR(255) NOT NULL,
    "email" VARCHAR(255) NOT NULL,
    "phone" VARCHAR(50),
    "status" VARCHAR(50) NOT NULL CHECK ("status" IN ('Nouveau', 'En discussion', 'En cours de process', 'Terminé')),
    "notes" TEXT,
    "createdAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "updatedAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table Opportunity
CREATE TABLE "opportunity" (
    "id" UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    "recruiterId" UUID NOT NULL,
    "jobTitle" VARCHAR(255) NOT NULL,
    "company" VARCHAR(255) NOT NULL,
    "contractType" VARCHAR(100) NOT NULL,
    "location" VARCHAR(255) NOT NULL,
    "salaryMin" FLOAT,
    "salaryMax" FLOAT,
    "salaryCurrency" VARCHAR(10),
    "status" VARCHAR(50) NOT NULL CHECK ("status" IN ('Nouveau', 'En discussion', 'Entretien planifié', 'Proposition reçue', 'Refusé', 'Accepté')),
    "createdAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "updatedAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY ("recruiterId") REFERENCES "recruiter"("id") ON DELETE CASCADE
);

-- Table Interaction
CREATE TABLE "interaction" (
    "id" UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    "recruiterId" UUID NOT NULL,
    "opportunityId" UUID NOT NULL,
    "type" VARCHAR(100) NOT NULL CHECK ("type" IN ('Email', 'Appel', 'Entretien', 'Autre')),
    "date" TIMESTAMP NOT NULL,
    "notes" TEXT,
    "nextSteps" TEXT,
    "createdAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY ("recruiterId") REFERENCES "recruiter"("id") ON DELETE CASCADE,
    FOREIGN KEY ("opportunityId") REFERENCES "opportunity"("id") ON DELETE CASCADE
);

-- Index pour améliorer les performances des recherches
CREATE INDEX idx_recruiter_status ON "recruiter"("status");
CREATE INDEX idx_opportunity_status ON "opportunity"("status");
CREATE INDEX idx_opportunity_recruiter ON "opportunity"("recruiterId");
CREATE INDEX idx_interaction_recruiter ON "interaction"("recruiterId");
CREATE INDEX idx_interaction_opportunity ON "interaction"("opportunityId");
CREATE INDEX idx_interaction_date ON "interaction"("date");

-- Trigger pour mettre à jour automatiquement le champ updatedAt pour recruiter
CREATE OR REPLACE FUNCTION update_recruiter_timestamp()
RETURNS TRIGGER AS $$
BEGIN
   NEW."updatedAt" = CURRENT_TIMESTAMP;
   RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_recruiter_timestamp
BEFORE UPDATE ON "recruiter"
FOR EACH ROW
EXECUTE FUNCTION update_recruiter_timestamp();

-- Trigger pour mettre à jour automatiquement le champ updatedAt pour opportunity
CREATE OR REPLACE FUNCTION update_opportunity_timestamp()
RETURNS TRIGGER AS $$
BEGIN
   NEW."updatedAt" = CURRENT_TIMESTAMP;
   RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_opportunity_timestamp
BEFORE UPDATE ON "opportunity"
FOR EACH ROW
EXECUTE FUNCTION update_opportunity_timestamp();